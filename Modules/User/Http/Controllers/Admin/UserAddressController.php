<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;

class UserAddressController extends MyAdminController
{
    public $model = 'Modules\User\Models\UserAddress';

    public $request = 'Modules\User\Http\Requests\UserAddressRequest';

    public $view = 'admin.address.';

    /**
     * 首页
     */
    public function index()
    {
        if (request()->ajax() && request()->wantsJson()) {
            $category = $this->getModel()::with(['user:id,name', 'province:id,name', 'city:id,name', 'district:id,name'])
                ->orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($category);
        }

        return $this->view($this->view . 'index');
    }

    /**
     * 添加页
     */
    public function create()
    {

        $provinces = app('system')->regions();

        return $this->view($this->view . 'create', compact('provinces'));
    }

    /**
     * 获取地区
     * @return \Illuminate\Http\JsonResponse
     */
    public function areas(): \Illuminate\Http\JsonResponse
    {
        $pid = $this->param('pid', 'intval');

        $areas = app('system')->regions($pid)->toArray();

        return $this->success(['data' => $areas]);
    }


    /**
     * 添加后操作
     * @param $id
     * @return bool
     */
    public function afterStore($id): bool
    {
        $username = $this->param('user_name');

        $user = app('user')->user($username);

        if ($user) {

            return $this->getModel()->where('id', $id)->update(['user_id' => $user->id]);

        }

        $this->getModel()->where('id', $id)->delete();

        return false;
    }

    /**
     * 编辑页
     */
    public function edit()
    {
        $data = $this->getModel()::find($this->param('id', 'intval'));

        $provinces = app('system')->regions();

        $cities = app('system')->regions($data->province_id);

        $districts = app('system')->regions($data->city_id);

        return $this->view($this->view . 'edit', compact('data', 'provinces', 'cities', 'districts'));
    }
}
