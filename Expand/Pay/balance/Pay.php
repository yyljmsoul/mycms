<?php

namespace Expand\Pay\balance;

use Expand\Pay\PayInterface;
use Illuminate\Http\JsonResponse;
use Modules\Order\Models\Order;

class Pay implements PayInterface
{

    /**
     * 支付提交
     * @param array $order
     * @param string $payType
     * @return JsonResponse
     */
    public function submit(array $order, $payType = ''): JsonResponse
    {
        $user = app('user')->user($order['user_id']);

        if ($user->balance >= $order['order_amount']) {

            $result = app('user')->balance(-$order['order_amount'], $order['user_id'], '订单使用：' . $order['order_sn']);

            if ($result) {

                return $this->notify($order);
            }

            return new JsonResponse(['msg' => '支付失败'], 401);
        }

        return new JsonResponse(['msg' => '余额不足'], 401);
    }

    /**
     * 支付回调
     * @param array $order
     * @return JsonResponse
     */
    public function notify(array $order = []): JsonResponse
    {
        $result = orderNotifyHandle($order['order_sn'], 'balance');

        if ($result) {

            return new JsonResponse(['msg' => '支付成功'], 200);
        }

        return new JsonResponse(['msg' => '支付失败'], 401);
    }

    /**
     * 退款
     * @param array $order
     * @return JsonResponse
     */
    public function refund(array $order): JsonResponse
    {
        $result = app('user')->balance($order['order_amount'], $order['user_id'], '订单退款：' . $order['order_sn']);

        if ($result) {

            Order::where('id', $order['id'])->update([
                'refund_time' => time(),
            ]);

            return new JsonResponse(['msg' => '退款成功'], 200);
        }

        return new JsonResponse(['msg' => '退款失败'], 401);
    }

    /**
     * 获取支付类型
     * @return string
     */
    public function getPayType()
    {
        return '';
    }
}
