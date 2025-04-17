<?php

namespace Modules\Api\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Doctrine\DBAL\Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataSourceController extends MyAdminController
{
    public $view = 'admin.data_source.';

    public $model = 'Modules\Api\Models\DataSourceModel';

    public $request = 'Modules\Api\Http\Requests\DataSourceRequest';


    /**
     * 首页
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|string
     */
    public function index()
    {
        if (request()->ajax() && request()->wantsJson()) {

            $tables = DB::select('show tables');
            $data = json_decode(json_encode($tables), true);
            $colum = array_keys($data[0])[0];

            $result = [];
            $data = array_column($data, $colum);

            foreach ($data as $value) {
                $result[] = ['id' => $value, 'name' => $value];
            }

            return $this->success(['data' => $result, 'total' => count($data), 'current_page' => 1, 'last_page' => 1, 'per_page' => 1000]);
        }

        return $this->view($this->view . 'index');
    }


    /**
     * 生成表
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $tableName = $this->param('table_name');
        $option = $this->option();

        Schema::create($tableName, function (Blueprint $table) use ($option){
            $table->id('id');
            foreach ($option as $item) {
                $this->schema($table, $item);
            }
            $table->timestamps();
        });

        return $this->success(['msg' => '创建成功']);
    }


    /**
     * @throws Exception
     */
    public function edit()
    {
        $tableName = $this->param('id');
        $columns = Schema::getColumnListing($tableName);
        $columns = array_diff($columns, ["id", "updated_at", "created_at"]);

        $data = [];
        $obj = DB::connection()->getDoctrineSchemaManager()
            ->listTableDetails($tableName);

        foreach ($columns as $value) {
            $item = $obj->getColumn($value)->toArray();
            $item['type'] = (new $item['type'])->getName();
            $data[] = $item;
        }

        return $this->view($this->view . 'edit', compact('data', 'tableName'));
    }


    /**
     * 修改表
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $tableName = $this->param('table_name');
        $option = $this->option();

        $columns = Schema::getColumnListing($tableName);
        $columns = array_diff($columns, ["id", "updated_at", "created_at"]);

        $requestCols = array_column($option, 'field_name');
        $delCols = array_diff($columns, $requestCols);
        $newCols = array_diff($requestCols, $columns);

        Schema::table($tableName, function (Blueprint $table) use ($option, $newCols, $delCols){

            if ($newCols) {
                foreach ($option as $item) {
                    if (in_array($item['field_name'], $newCols)) {
                        $this->schema($table, $item);
                    }
                }
            }

            if ($delCols) {
                $table->dropColumn($delCols);
            }

        });

        return $this->success(['msg' => '更新成功']);
    }

    /**
     * 组合字段参数
     * @return array
     */
    private function option()
    {
        $option = [];

        $fieldName = $this->param('field_name');
        $fieldType = $this->param('field_type');
        $defaultValue = $this->param('field_default_value');
        $fieldRemark = $this->param('field_remark');

        foreach ($fieldName as $key => $value) {
            if ($value) {
                $option[] = [
                    'field_name' => $value,
                    'field_type' => $fieldType[$key],
                    'default_value' => $defaultValue[$key],
                    'field_remark' => $fieldRemark[$key],
                ];
            }
        }

        return $option;
    }

    /**
     * 类型匹配
     * @param Blueprint $table
     * @param $option
     * @return void
     */
    private function schema(Blueprint &$table, $option)
    {
        switch ($option['field_type']) {
            case 'int':
                $table->integer($option['field_name'])->default($option['default_value'] ?: '0')->comment($option['field_remark']);
                break;
            case 'bigint':
                $table->bigInteger($option['field_name'])->default($option['default_value'] ?: '0')->comment($option['field_remark']);
                break;
            case 'decimal':
                $table->decimal($option['field_name'], 10)->default($option['default_value'] ?: '0')->comment($option['field_remark']);
                break;
            case 'timestamp':
                $table->timestamp($option['field_name'])->nullable()->comment($option['field_remark']);
                break;
            case 'varchar':
                $table->string($option['field_name'], 255)->default($option['default_value'] ?: '')->comment($option['field_remark']);
                break;
            case 'text':
                $table->text($option['field_name'])->nullable()->comment($option['field_remark']);
                break;
            case 'longtext':
                $table->longText($option['field_name'])->nullable()->comment($option['field_remark']);
                break;
        }

    }
}
