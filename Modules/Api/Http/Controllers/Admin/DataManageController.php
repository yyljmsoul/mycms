<?php

namespace Modules\Api\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\SchemaException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DataManageController extends MyAdminController
{

    public $view = 'admin.data_manage.';

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     * @throws Exception
     */
    public function index()
    {
        $tableName = $this->param('table');

        if (request()->ajax() && request()->wantsJson()) {
            $data = DB::table($tableName)->orderBy('id', 'desc')->paginate()->toArray();
            return $this->success($data);
        }

        $columns = [];
        $fields = Schema::getColumnListing($tableName);
        $obj = DB::connection()->getDoctrineSchemaManager()
            ->listTableDetails($tableName);

        foreach ($fields as $value) {
            $item = $obj->getColumn($value)->toArray();
            $item['type'] = (new $item['type'])->getName();
            $columns[] = $item;
        }

        return $this->view($this->view . 'index', compact('tableName', 'columns'));
    }


    /**
     * @throws SchemaException
     * @throws Exception
     */
    public function create()
    {
        $tableName = $this->param('table');

        $columns = [];
        $fields = Schema::getColumnListing($tableName);
        $fields = array_diff($fields, ["id", "updated_at", "created_at"]);
        $obj = DB::connection()->getDoctrineSchemaManager()
            ->listTableDetails($tableName);

        foreach ($fields as $value) {
            $item = $obj->getColumn($value)->toArray();
            $item['type'] = (new $item['type'])->getName();
            $columns[] = $item;
        }

        return $this->view($this->view . 'create', compact('tableName', 'columns'));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $tableName = $this->param('table');
        $fields = Schema::getColumnListing($tableName);
        $params = array_diff($fields, ["id", "updated_at", "created_at"]);

        $data = request()->all($params);
        if (in_array("created_at", $fields)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        if (in_array("updated_at", $fields)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $result = DB::table($tableName)->insert($data);

        return $this->result($result);
    }


    /**
     * @throws Exception
     * @throws SchemaException
     */
    public function edit()
    {
        $tableName = $this->param('table');
        $id = $this->param('id');

        $columns = [];
        $fields = Schema::getColumnListing($tableName);
        $fields = array_diff($fields, ["id", "updated_at", "created_at"]);
        $obj = DB::connection()->getDoctrineSchemaManager()
            ->listTableDetails($tableName);

        foreach ($fields as $value) {
            $item = $obj->getColumn($value)->toArray();
            $item['type'] = (new $item['type'])->getName();
            $columns[] = $item;
        }

        $data = DB::table($tableName)->where('id', $id)->first();
        $data = json_decode(json_encode($data), true);
        return $this->view($this->view . 'edit', compact('tableName', 'columns', 'data'));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $id = $this->param('id');
        $tableName = $this->param('table');
        $fields = Schema::getColumnListing($tableName);
        $params = array_diff($fields, ["id", "updated_at", "created_at"]);

        $data = request()->all($params);

        if (in_array("updated_at", $fields)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $result = DB::table($tableName)->where('id', $id)->update($data);

        return $this->result($result);
    }


    /**
     * 删除数据
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $id = $this->param('id');
        $tableName = $this->param('table');

        $result = DB::table($tableName)->where('id', $id)->delete();
        return $this->result($result);
    }

}
