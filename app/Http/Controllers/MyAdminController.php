<?php


namespace App\Http\Controllers;


use App\Models\MyModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class MyAdminController extends MyController
{

    public $model = '';

    public $request = '';

    public $view = 'admin.';

    public $with = [];

    public $editWith = [];

    public $indexOrderBy = 'id';

    public $indexSort = 'desc';

    public function __call($method, $parameters)
    {
        if (method_exists($this, "{$method}Action")) {
            return $this->{"{$method}Action"}();
        }

        parent::__call($method, $parameters);
    }

    /**
     * 获取关联模型
     */
    public function getModel(): MyModel
    {
        return (new $this->model);
    }

    /**
     * 获取管理请求对象
     */
    public function getRequest(): FormRequest
    {
        return app($this->request);
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        if (request()->ajax() && request()->wantsJson()) {

            $data = $this->getModel()::with($this->with)
                ->where($this->getIndexWhere())
                ->orderBy($this->indexOrderBy, $this->indexSort)
                ->paginate($this->param('limit', 'intval'))
                ->toArray();

            return $this->success($this->indexDataFormat($data));
        }

        return $this->view($this->view . 'index');
    }


    /**
     * @param $data
     * @return mixed
     */
    public function indexDataFormat($data)
    {
        return $data;
    }


    /**
     * @return array
     */
    public function getIndexWhere(): array
    {
        $where = [];

        if ($json = request()->input('filter')) {
            $filters = json_decode($json, true);
            foreach ($filters as $name => $filter) {
                $where[] = [$name, 'like', "%{$filter}%"];
            }
        }

        return $where;
    }


    /**
     * 创建页
     */
    public function createAction()
    {
        $data = [];

        if (method_exists($this, '_create')) {
            $data = $this->_create();
        }

        return $this->view($this->view . 'create', compact('data'));
    }

    /**
     * @return \stdClass|array
     */
    public function _create()
    {
        return [];
    }

    /**
     * 创建记录
     */
    public function storeAction(): JsonResponse
    {
        $data = $this->getRequest()->validated();

        $model = $this->getModel();
        $result = $model->store($data);

        if (method_exists($this, 'afterStore')) {
            $result = $this->afterStore($model->id);
        }

        return $this->result($result);
    }

    /**
     * 编辑页
     */
    public function editAction()
    {
        $data = $this->getModel()::with($this->editWith)
            ->find($this->param('id', 'intval'));

        if (method_exists($this, '_edit')) {
            $editData = $this->_edit();
            foreach ($editData as $key => $value) {
                $data->{$key} = $value;
            }
        }

        return $this->view($this->view . 'edit', compact('data'));
    }

    /**
     * @return array
     */
    public function _edit(): array
    {
        return [];
    }

    /**
     * 更新记录
     */
    public function updateAction(): JsonResponse
    {

        if ($id = $this->param('id', 'intval')) {

            $data = $this->getRequest()->validated();
            $data['id'] = $id;

            $model = $this->getModel();
            $result = $model->up($data);

            if (method_exists($this, 'afterUpdate')) {
                $result = $this->afterUpdate($id);
            }

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除记录
     */
    public function destroyAction(): JsonResponse
    {
        $id = $this->param('id', 'intval');

        if (method_exists($this, 'beforeDestroy')) {
            $this->beforeDestroy($id);
        }

        $result = $this->getModel()::destroy($id);

        if (method_exists($this, 'afterDestroy')) {
            $result = $this->afterDestroy($id);
        }

        return $this->result($result);
    }


    /**
     * 修改属性
     * @return JsonResponse
     */
    public function modifyAction(): JsonResponse
    {
        $result = false;

        if ($id = $this->param('id', 'intval')) {

            $object = $this->getModel()::find($id);
            $object->{$this->param('field')} = $this->param('value');
            $result = $object->save();
        }

        return $this->result($result);
    }


    /**
     * 排序
     * 大的排在前面
     * @return JsonResponse
     */
    public function sortAction(): JsonResponse
    {
        $ids = $this->param('ids');
        $count = count($ids);

        foreach ($ids as $key => $id) {

            $this->getModel()->where('id', $id)->update([
                'sort' => $count - $key
            ]);
        }

        return $this->success();
    }
}
