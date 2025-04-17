<?php

namespace Expand\Pay;

use Illuminate\Http\JsonResponse;

class Pay
{

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * 提交支付
     * @param $order
     * @param string $payType
     * @return JsonResponse
     */
    public function submit($order, $payType = ''): JsonResponse
    {
        if ($object = $this->getObject()) {

            return $object->submit($order, $payType);
        }

        return new JsonResponse(['msg' => '暂不支持该支付方式'], 401);
    }

    /**
     * 订单退款
     * @param $order
     * @return JsonResponse
     */
    public function refund($order): JsonResponse
    {
        if ($object = $this->getObject()) {

            return $object->refund($order);
        }

        return new JsonResponse(['msg' => '暂不支持该退款方式'], 401);
    }

    /**
     * 订单回调
     */
    public function notify()
    {
        if ($object = $this->getObject()) {

            return $object->notify();
        }

        return new JsonResponse(['msg' => '暂不支持该退款方式'], 401);
    }

    /**
     * 获取支付对象
     * @return \Illuminate\Contracts\Foundation\Application|mixed|null
     */
    protected function getObject()
    {
        if (in_array($this->type, array_keys(config('pay.pay_list')))) {

            return app('Expand\Pay\\'.$this->type.'\Pay');
        }

        return null;
    }
}
