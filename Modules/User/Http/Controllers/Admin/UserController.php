<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\User\Http\Requests\UserPwdRequest;
use Modules\User\Http\Requests\UserStoreRequest;
use Modules\User\Http\Requests\UserUpdateRequest;
use Modules\User\Models\User;

class UserController extends MyController
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $admins = User::with("userRank:id,name")->orderBy('id', 'desc')
                ->where($this->adminFilter($request->input('filter')))
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($admins);
        }
        return $this->view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ranks = app('user')->ranks();
        return $this->view('admin.user.create', compact('ranks'));
    }

    /**
     * Store a newly created resource in storage.
     * @param UserStoreRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request, User $user)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $result = $user->store($data);

        return $this->result($result);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $ranks = app('user')->ranks();
        $user = User::find($this->param('id', 'intval'));

        return $this->view('admin.user.edit', compact('user', 'ranks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();
        $result = $user->up($data);

        return $this->result($result);
    }

    /**
     * 密码编辑页面
     */
    public function password()
    {
        $user = User::find($this->param('id', 'intval'));
        return $this->view('admin.user.password', compact('user'));
    }

    /**
     * 设置密码
     */
    public function setPwd(UserPwdRequest $request, User $user)
    {
        $data = $request->validated();
        $result = $user->up(['password' => Hash::make($data['password']), 'id' => $data['id']]);

        return $this->result($result);
    }

    /**
     * 修改字段
     */
    public function modify()
    {
        $user = User::find($this->param('id', 'intval'));
        $user->{$this->param('field')} = $this->param('value');
        $result = $user->save();

        return $this->result($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $result = User::destroy($this->param('id', 'intval'));
        return $this->result($result);
    }

    /**
     * 变动资金页面
     */
    public function account()
    {
        $user = User::find($this->param('id', 'intval'));
        return $this->view('admin.user.account', compact('user'));
    }

    /**
     * 变动资金
     */
    public function setAccount()
    {

        $balanceRes = $pointRes = true;
        $id = $this->param('id', 'intval');
        $desc = $this->param('description');

        if ($balance = $this->param('balance', 'floatval')) {
            $balanceRes = app('user')->balance($balance, $id, $desc);
        }

        if ($point = $this->param('point', 'floatval')) {
            $pointRes = app('user')->point($point, $id, $desc);
        }

        return $this->result($balanceRes && $pointRes);
    }
}
