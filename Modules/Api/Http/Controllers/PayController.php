<?php

namespace Modules\Api\Http\Controllers;

use Expand\Pay\Pay;
use Illuminate\Http\JsonResponse;
use Modules\Api\Http\Requests\PaySubmitRequest;
use Modules\Order\Models\Order;

class PayController extends ApiController
{

    /**
     * 统一支付
     * @param $orderSn
     * @return JsonResponse
     */
    public function order($orderSn): JsonResponse
    {
        $uid = $this->getUserId();

        $order = Order::where('order_sn', $orderSn)
            ->where('order_status', 0)
            ->where('user_id', $uid)
            ->first();

        if ($order) {

            $result = [
                'order_sn' => $orderSn,
                'order_amount' => $order->order_amount,
                'pay_types' => [
                    'balance'
                ]
            ];

            return $this->success($result);
        }

        return $this->error(['msg' => '订单无法支付']);
    }

    /**
     * 支付提交
     * @param PaySubmitRequest $request
     * @return JsonResponse
     */
    public function submit(PaySubmitRequest $request): JsonResponse
    {
        $data = $request->validated();

        $uid = $this->getUserId();

        $order = Order::with(['user:id,openid'])
            ->where('order_sn', $data['order_sn'])
            ->where('order_status', 0)
            ->where('user_id', $uid)
            ->first();

        if ($order) {

            $pay = new Pay($data['pay_type']);

            $response = $pay->submit($order->toArray());

            $result = json_decode($response->getContent(), true);

            return $this->success($result);
        }

        return $this->error(['msg' => '该订单无需重复支付']);
    }


    /**
     * 订单回调
     * @param $type
     * @return void
     */
    public function notify($type)
    {
        $pay = new Pay($type);

        $pay->notify();
    }
}
