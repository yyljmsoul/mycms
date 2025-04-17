<?php

namespace Modules\Api\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Illuminate\Support\Facades\Schema;
use Modules\Api\Models\ApiProjectModel;
use Modules\Api\Models\DataSourceModel;
use function AlibabaCloud\Client\json;

class ApiController extends MyAdminController
{
    public $view = 'admin.api.';

    public $model = 'Modules\Api\Models\ApiModel';

    public $request = 'Modules\Api\Http\Requests\ApiRequest';


    /**
     * 获取项目列表
     * @return mixed
     */
    private function projects()
    {
        return ApiProjectModel::get()->toArray();
    }

    public function _create(): array
    {
        return $this->projects();
    }

    /**
     * 编辑页
     */
    public function edit()
    {
        $data = $this->getModel()::with($this->editWith)
            ->find($this->param('id', 'intval'));

        $columns = [];
        if ($data->table_name) {
            $columns = Schema::getColumnListing($data->table_name);
        }

        if ($data->fields) {
            $data->fields = json_decode($data->fields, true);
        }

        $data->response = json_decode($data->response, true) ?: [];
        $data->rel_table = json_decode($data->rel_table, true) ?: [];

        $order_fields = [];
        if ($data->order_field) {
            $data->order_field = json_decode($data->order_field, true) ?: [];
            $order_fields = array_keys($data->order_field);
        }

        $projects = $this->projects();

        return $this->view($this->view . 'edit', compact('data', 'columns', 'order_fields', 'projects'));
    }

    public function afterStore($id)
    {
        $this->afterAction($id);
    }


    public function afterUpdate($id)
    {
        $this->afterAction($id);
    }

    private function afterAction($id)
    {
        $params = [];
        $response = [];

        $rel_table = $this->param('rel_table') ?: [];
        $fields = $this->param('response_fields') ?: [];
        $orderFields = [];
        $orderParams = $this->param('order_fields');
        if ($fields) {
            foreach ($fields as $key => $value) {
                $orderFields[$value] = $orderParams[$value];
            }
        }

        $fields = json_encode($fields);
        $orderFields = json_encode($orderFields);

        $names = $this->param('param_name');
        $required = $this->param('param_required');
        $default_value = $this->param('param_default_value');
        $remark = $this->param('param_remark');
        $filter_type = $this->param('param_filter_type');

        foreach ($names as $key => $value) {

            if ($value) {
                $params[] = [
                    'name' => $value,
                    'required' => $required[$key] ?? 0,
                    'default' => $default_value[$key],
                    'remark' => $remark[$key],
                    'filter_type' => $filter_type[$key],
                ];
            }
        }

        $params = json_encode($params);

        $names = $this->param('content_name');
        $default_value = $this->param('content_value');
        $remark = $this->param('content_remark');

        foreach ($names as $key => $value) {
            if ($value) {
                $response[] = [
                    'name' => $value,
                    'value' => $default_value[$key],
                    'remark' => $remark[$key],
                ];
            }
        }

        $response = json_encode($response);

        $this->getModel()->where('id', $id)->update([
            'params' => $params,
            'fields' => $fields,
            'order_field' => $orderFields,
            'response' => $response,
            'rel_table' => json_encode($rel_table),
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function tableFields(): \Illuminate\Http\JsonResponse
    {
        $table = $this->param('table');
        $columns = Schema::getColumnListing($table);

        return $this->success(['data' => $columns]);
    }
}
