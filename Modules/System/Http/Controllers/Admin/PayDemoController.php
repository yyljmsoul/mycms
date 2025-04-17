<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Expand\Pay\Pay;
use Modules\Order\Models\Order;

class PayDemoController extends MyController
{
    /**
     * 微信支付示例表单
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function wechatForm()
    {
        return $this->view('admin.demo.wechat_form');
    }


    /**
     * 微信支付提交
     * @return \Illuminate\Http\JsonResponse
     */
    public function wechatPay()
    {
        $money = $this->param('money');
        $payType = $this->param('pay_type');
        $openid = $this->param('openid');

        $orderId = $this->makeOrder($money, $payType == 'miniapp' ? 'miniapp' : 'wechat');
        $order = Order::find($orderId)->toArray();

        $pay = new Pay($order['pay_type']);

        if ($openid) {
            $order['user']['openid'] = $openid;
        }

        return $pay->submit($order, $payType);
    }


    /**
     * 支付宝测试表单
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|string
     */
    public function alipayForm()
    {
        return $this->view('admin.demo.alipay_form');
    }


    /**
     * 支付宝提交
     * @return \Illuminate\Http\JsonResponse
     */
    public function alipayPay()
    {
        $money = $this->param('money');
        $payType = $this->param('pay_type');

        $orderId = $this->makeOrder($money, 'alipay');
        $order = Order::find($orderId)->toArray();

        $pay = new Pay($order['pay_type']);

        return $pay->submit($order, $payType);
    }

    /**
     * 生成测试订单
     * @param $money
     * @param $payType
     * @return false|mixed
     */
    protected function makeOrder($money, $payType)
    {
        $order = [
            'user_id' => 0,
            'order_sn' => app('store')->makeOrderSn(),
            'out_trade_no' => '',
            'order_amount' => $money,
            'goods_money' => $money,
            'delivery_money' => 0,
            'order_status' => Order::ORDER_STATUS_WAIT_PAY,
            'pay_status' => Order::PAY_STATUS_WAIT,
            'delivery_status' => Order::DELIVERY_STATUS_WAIT,
            'pay_type' => $payType,
            'delivery_type' => '',
            'delivery_code' => '',
            'receive_name' => '',
            'receive_telephone' => '',
            'receive_province' => '0',
            'receive_city' => '0',
            'receive_district' => '0',
            'receive_address' => '',
            'create_time' => time(),
            'pay_time' => 0,
            'delivery_time' => 0,
            'close_time' => 0,
            'remark' => '',
        ];

        return Order::insert($order);
    }
}
