<?php

namespace Modules\Api\Http\Controllers;

use App\Http\Controllers\MyController;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Api\Models\ApiModel;
use Modules\User\Models\User;

class ApiController extends MyController
{
    protected $error = '返回失败';
    /**
     * @var string
     */
    protected $success = '返回成功';

    private $requestParams;

    public $apiIdent = '';

    public $apiMethod = '';

    /**
     * 无头CMS 接口入口
     * @return \Illuminate\Http\JsonResponse
     * @throws BindingResolutionException
     */
    public function entry($ident = '')
    {
        $path = $this->apiIdent ?: request()->input('path');
        $method = $this->apiMethod ?: request()->method();
        $api = ApiModel::where('path', $path)->where('project_ident', $ident)
            ->where('method', $method)->first();

        if (empty($api)) {
            return $this->implicitExp($path, $method);
        }

        $this->requestParams = $this->validateParams($api->params);
        if (!is_array($this->requestParams)) {
            return $this->requestParams;
        }

        $api->use_count += 1;
        $api->save();

        return $this->{$api->source_type . "Action"}($api);
    }


    /**
     * 读取数据表
     * @param $api
     * @return \Illuminate\Http\JsonResponse
     */
    private function tableAction($api)
    {
        $limit = request()->input('limit', 15);

        $api->fields = json_decode($api->fields, true);
        $api->rel_table = json_decode($api->rel_table, true);
        $fields = $api->fields ?: ['*'];

        $query = DB::table($api->table_name)->where(function ($query) use ($api) {
            $requestParams = json_decode($api->params, true);
            $requestParams = array_column($requestParams, null, 'name');
            foreach ($this->requestParams as $key => $value) {
                if (!isset($requestParams[$key]['filter_type']) || $requestParams[$key]['filter_type'] == '=') {
                    $query->where($api->table_name . "." . $key, $value);
                } else {
                    $query->where($api->table_name . "." . $key, 'like', "%$value%");
                }
            }
        });

        if ($api->rel_table) {
            $api->rel_table = array_filter($api->rel_table);
            if ($api->fields) {
                $fields = array_map(function ($item) use ($api) {
                    return "{$api->table_name}.{$item}";
                }, $fields);
            }
            foreach ($api->rel_table as $f => $rel) {
                if (strstr($rel, ":") === false) {
                    $query->join($rel, $api->table_name . ".{$f}", "=", "{$rel}.id");
                    if ($api->fields) {
                        $fields[] = "{$rel}.*";
                    }
                } else {
                    [$table, $relFields] = explode(":", $rel);
                    $query->join($table, $api->table_name . ".{$f}", "=", "{$table}.id");
                    if ($api->fields) {
                        $array = explode(",", $relFields);
                        foreach ($array as $rf) {
                            $fields[] = "{$table}.{$rf}";
                        }
                    }
                }
            }
        }

        if (function_exists(Str::camel($api->table_name) . "Scope")) {
            $query = call_user_func_array(Str::camel($api->table_name) . "Scope", [$query, $api->table_name]);
        }

        $query->select($fields);

        if ($order = json_decode($api->order_field, true)) {
            $order = array_filter($order);
            foreach ($order as $field => $sort) {
                $query->orderBy($field, $sort);
            }
        }

        if ($api->return_type == 'object') {
            $result = $query->first();
            if ($result && $api->count_field) {
                $view = $result->{$api->count_field} + 1;
                DB::table($api->table_name)->where('id', $result->id)->update([$api->count_field => $view]);
            }
        } else {
            $result = $query->paginate($limit);
        }

        return $this->success(['data' => $result]);
    }


    /**
     * 转发请求
     * @param $api
     * @return \Illuminate\Http\JsonResponse
     * @throws GuzzleException
     */
    private function requestAction($api)
    {
        $url = $api->request_url;
        $option = [];

        if ($api->method == 'GET') {
            if (strstr($url, "?") !== false) {
                $url .= "&" . http_build_query($this->requestParams);
            } else {
                $url .= "?" . http_build_query($this->requestParams);
            }
        } else {
            $option['form_params'] = $this->requestParams;
        }

        $headers = json_decode($api->headers, true);
        if ($headers) {
            foreach ($headers as $header) {
                $option['headers'][$header['name']] = $header['value'];
            }
        }

        $client = new Client();
        $response = $client->request($api->method, $url, $option);
        $content = $response->getBody()->getContents();

        $result = json_decode($content, true);
        return $this->success($result);
    }


    /**
     * 固定返回内容
     * @param $api
     * @return \Illuminate\Http\JsonResponse
     */
    private function contentAction($api): \Illuminate\Http\JsonResponse
    {
        $response = [];
        $array = json_decode($api->response, true);
        foreach ($array as $value) {
            if (isset($response[$value['name']]) && !is_array($response[$value['name']]) && $response[$value['name']]) {
                $response[$value['name']] = [
                    $response[$value['name']],
                    $value['value']
                ];
            } elseif (isset($response[$value['name']]) && is_array($response[$value['name']])) {
                $response[$value['name']][] = $value['value'];
            } else {
                $response[$value['name']] = $value['value'];
            }

        }
        return $this->success(['data' => $response]);
    }


    /**
     * @throws Exception
     */
    private function diyAction($api): \Illuminate\Http\JsonResponse
    {
        $handle = str_replace(".php", "", $api->handle);
        $handle = str_replace("/", "\\", $handle);

        $object = app()->make($handle);
        $result = $object->handle($this->requestParams);

        if (is_array($result)) {
            return $this->success($result);
        }

        return $result;
    }


    /**
     * @param $path
     * @param $method
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function implicitExp($path, $method)
    {
        $str = ucwords(str_replace(['-', '_'], ' ', $path));
        $filename = str_replace(' ', '', $str) . 'Handle';
        $file = base_path('Expand/Api/handles/' . $filename . '.php');
        if (!file_exists($file)) {
            return $this->error(['msg' => '非法接口', 'code' => 403]);
        }

        $handle = str_replace("/", "\\", 'Expand/Api/handles/' . $filename);

        $object = app()->make($handle);
        if ($object->method != $method) {
            return $this->error(['msg' => '非法接口', 'code' => 403]);
        }

        if ($object->validate_token) {
            $userId = $this->validateToken();
            if (!$userId) {
                return $this->error(['msg' => '非法令牌']);
            }
            $object->user_id = $userId;
        } else {
            $userId = $this->validateToken();
            $object->user_id = $userId;
        }

        if (empty($object->params) && $object->required_params) {
            $object->params = $object->required_params;
        }

        foreach ($object->params as $param) {
            if (in_array($param, $object->json_params)) {
                $value = request()->input($param);
                $jsonArray = json_decode($value, true);
                if ($jsonArray === false) {
                    return $this->error(['msg' => $param . '参数错误', 'code' => 400]);
                } else {
                    if (empty($jsonArray) && in_array($param, $object->required_params)) {
                        return $this->error(['msg' => $param . '参数缺失', 'code' => 400]);
                    }
                    $this->requestParams[$param] = $value;
                }
            } else {
                $value = $this->param($param);
                if (($value === '' || $value === null) && in_array($param, $object->required_params)) {
                    return $this->error(['msg' => $param . '参数缺失', 'code' => 400]);
                } else {
                    $this->requestParams[$param] = $value;
                }
            }
        }

        $result = $object->handle($this->requestParams);
        if (is_array($result)) {
            return $this->success($result);
        }

        return $result;
    }


    /**
     * 验证token
     * @return int
     */
    protected function validateToken()
    {
        $token = request()->header('Authorization');
        if ($token) {
            $user = User::where('remember_token', $token)->first();
            return $user ? $user->id : 0;
        }

        return 0;
    }


    /**
     * 验证参数
     * @param $params
     * @return array|\Illuminate\Http\JsonResponse
     */
    private function validateParams($params)
    {
        $requestParams = [];
        $params = json_decode($params, true);
        foreach ($params as $param) {
            $input = $this->param($param['name'], '', $param['default']);
            if ($input === '' && $param['required']) {
                return $this->error(['msg' => ($param['remark'] ?: $param['name']) . '参数缺失', 'code' => 400]);
            } elseif ($input !== '') {
                $requestParams[$param['name']] = $input;
            }
        }

        return $requestParams;
    }


    /**
     * 过滤对象需要的字段
     * @param $data
     * @param $fields
     * @param $reject
     * @return array
     */
    public function objectFilterField($data, $fields = [], $reject = false): array
    {
        $values = [];
        $array = $data && !is_array($data) ? $data->toArray() : ($data ?: []);

        array_map(function ($item, $key) use ($fields, $reject, &$values) {

            if (
                ($reject === false && in_array($key, $fields)) ||
                ($reject === true && !in_array($key, $fields))
            ) {
                $values[$key] = is_null($item) ? '' : $item;
            }

        }, $array, array_keys($array));

        return $values;
    }

    /**
     * 过滤集合需要的字段
     * @param $data
     * @param array $fields
     * @param bool $reject
     * @return array
     */
    public function collectFilterField($data, $fields = [], $reject = false): array
    {
        $values = [];

        foreach ($data as $value) {

            $tmp = [];
            $array = !is_array($value) ? $value->toArray() : $value;

            foreach ($array as $key => $item) {
                if (
                    ($reject === false && in_array($key, $fields)) ||
                    ($reject === true && !in_array($key, $fields))
                ) {
                    $tmp[$key] = is_null($item) ? '' : $item;
                }
            }

            $values[] = $tmp;
        }

        return $values;
    }

    /**
     * 获取分页字段
     * @param $object
     * @return array
     */
    public function pageFilterField($object): array
    {
        return [
            'total' => $object->total(),
            'last_page' => $object->lastPage(),
            'current_page' => $object->currentPage(),
            'per_page' => $object->perPage()
        ];
    }


    /**
     * 获取用户ID
     * @return array|mixed|string|string[]|null
     */
    public function getUserId()
    {
        return $this->param('uid', 'intval');
    }

}
