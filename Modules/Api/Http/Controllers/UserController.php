<?php


namespace Modules\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\User\Http\Requests\UserAddressRequest;

class UserController extends ApiController
{
    /**
     * 用户登录
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $username = $this->param("username");
        $password = $this->param("password");

        $user = app('user')->user($username);

        if ($user && $user->status == 1 && Hash::check($password, $user->password)) {
            return $this->success([
                'result' => $this->objectFilterField($user, ['password', 'status', 'remember_token'], true)
            ]);
        }

        return $this->error(['msg' => "验证失败"]);

    }

    /**
     * 会员注册
     * @return JsonResponse
     */
    public function reg(): JsonResponse
    {
        $username = $this->param("username");
        $password = $this->param("password");
        $mobile = $this->param("mobile");

        if (
            !empty($username) &&
            !empty($password) &&
            $uid = app('user')->generateUser($username, $password, $mobile)
        ) {

            return $this->success(['result' => $uid]);
        }

        return $this->error(['msg' => "注册失败"]);
    }

    /**
     * 会员信息
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        $id = $this->getUserId();
        $user = app('user')->user($id);

        return $user ? $this->success([
            'result' => $this->objectFilterField(
                app('user')->userFields($user), ['password', 'remember_token'], true
            )
        ]) : $this->error(['msg' => "获取失败"]);
    }

    /**
     * 会员等级列表
     * @return JsonResponse
     */
    public function ranks(): JsonResponse
    {
        $ranks = app('user')->ranks();

        return $this->success([
            'result' => $this->collectFilterField(
                $ranks, ['created_at', 'updated_at'], true
            )
        ]);
    }

    /**
     * 会员收货地址列表
     * @return JsonResponse
     */
    public function addresses(): JsonResponse
    {
        $uid = $this->getUserId();

        $addresses = app('user')->addresses($uid);

        return $this->success([
            'result' => $this->collectFilterField(
                $addresses, ['created_at', 'updated_at'], true
            )
        ]);
    }

    /**
     * 会员收货地址详情
     * @return JsonResponse
     */
    public function address(): JsonResponse
    {
        $uid = $this->getUserId();
        $id = $this->param("id", 'intval');

        $address = app('user')->address($id, $uid);

        return $this->success([
            'result' => $this->objectFilterField(
                $address, ['created_at', 'updated_at'], true
            )
        ]);
    }

    /**
     * 会员收货地址详情
     * @return JsonResponse
     */
    public function defaultAddress(): JsonResponse
    {
        $uid = $this->getUserId();

        $address = app('user')->getUserDefaultAddress($uid);

        return $this->success([
            'result' => $this->objectFilterField(
                $address, ['created_at', 'updated_at'], true
            )
        ]);
    }

    /**
     * 添加会员收货地址
     * @param UserAddressRequest $request
     * @return JsonResponse
     */
    public function addressStore(UserAddressRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['user_id'] = $this->getUserId();

        $result = app('user')->addressStore($data);

        return $result ? $this->success([
            'msg' => "添加成功"
        ]) : $this->error(['msg' => "添加失败"]);
    }

    /**
     * 更新会员收货地址
     * @param UserAddressRequest $request
     * @return JsonResponse
     */
    public function addressUpdate(UserAddressRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $this->getUserId();

        $id = $this->param("id", 'intval');

        $result = app('user')->addressUpdate($data, $id);

        return $result ? $this->success([
            'msg' => "更新成功"
        ]) : $this->error(['msg' => "更新失败"]);
    }


    /**
     * 删除会员收货地址
     * @return JsonResponse
     */
    public function addressDelete(): JsonResponse
    {
        $uid = $this->getUserId();
        $id = $this->param("id", 'intval');

        $result = app('user')->addressDelete($uid, $id);

        return $result ? $this->success([
            'msg' => "删除成功"
        ]) : $this->error(['msg' => "删除失败"]);
    }
}
