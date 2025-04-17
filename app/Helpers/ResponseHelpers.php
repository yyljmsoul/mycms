<?php


namespace App\Helpers;

use Illuminate\Http\JsonResponse;

trait ResponseHelpers
{

    protected $success_msg = '操作成功';
    protected $success_code = 200;

    protected $error_msg = '操作失败';
    protected $error_code = 401;

    /**
     * 通用响应
     * @param $result
     * @param $data
     * @return JsonResponse
     */
    public function result($result = true, $data = []): JsonResponse
    {
        return $result !== false ? $this->success($data) : $this->error($data);
    }

    /**
     * 成功响应
     * @param $message
     * @return JsonResponse
     */
    public function success($message = []): JsonResponse
    {
        $option = [];
        $option['msg'] = is_string($message) ? $message : ($message['msg'] ?? $this->success_msg);
        $option['code'] = is_string($message) ? $this->success_code : ($message['code'] ?? $this->success_code);

        if (is_array($message)) {
            $option = array_merge($option, $message);
        }

        return new JsonResponse($option, $option['code']);
    }

    /**
     * 错误响应
     * @param $message
     * @return JsonResponse
     */
    public function error($message = []): JsonResponse
    {
        $option = [];
        $option['msg'] = is_string($message) ? $message : ($message['msg'] ?? $this->error_msg);
        $option['code'] = is_string($message) ? $this->error_code : ($message['code'] ?? $this->error_code);

        if (is_array($message)) {
            $option = array_merge($option, $message);
        }

        return new JsonResponse($option, $option['code']);
    }

    /**
     * 内容转数组
     * @param string $content
     * @return mixed
     */
    public function contentToArray(string $content)
    {
        return json_decode($content, true);
    }
}
