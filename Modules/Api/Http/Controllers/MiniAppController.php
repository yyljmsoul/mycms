<?php

namespace Modules\Api\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Modules\User\Models\User;

class MiniAppController extends ApiController
{
    /**
     * 获取信息
     * @throws GuzzleException
     */
    public function info(): \Illuminate\Http\JsonResponse
    {
        $code = $this->param('code');
        $nickname = $this->param('nickname');
        $img = $this->param('img');

        $uid = $this->getUserId();

        if ($result = app('miniApp')->code2Session($code)) {

            $result['unionid'] = $result['unionid'] ?? '';

            User::where('id', $uid)->update([
                'nickname' => urldecode($nickname),
                'img' => $img,
                'unionid' => $result['unionid'],
                'openid' => $result['openid'],
            ]);
        }

        return $this->success();
    }


    /**
     * 手机号登录
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(): \Illuminate\Http\JsonResponse
    {
        $code = $this->param('code');
        $uid = 0;

        if ($phone = app('miniApp')->getPhoneNumber($code)) {

            $user = app('user')->user(['mobile', '=', $phone]);

            if (!$user) {

                $uid = app('user')->generateUser($phone, $phone, $phone);

            } else {

                $uid = $user->id;
            }
        }

        return $this->success(['result' => $uid]);
    }
}
