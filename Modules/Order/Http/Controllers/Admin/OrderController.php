<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Modules\Order\Http\Requests\OrderDeliveryRequest;
use Modules\Order\Models\Order;

class OrderController extends MyAdminController
{

    /**
     * 首页
     */
    public function index()
    {
        if (request()->ajax() && request()->wantsJson()) {

            $data = Order::with(["user:id,name"])
                ->orderBy('id', 'desc')
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($data);
        }

        return $this->view('admin.order.index');
    }


    /**
     * 详情
     */
    public function detail()
    {
        $id = $this->param('id', 'intval');

        $order = Order::with([
            'user:id,name',
            'goods:id,order_id,goods_id,goods_name,shop_price,number,goods_money',
            'province:id,name', 'city:id,name', 'district:id,name'
        ])->where('id', $id)->first();

        return $this->view('admin.order.detail', compact('order'));
    }


    /**
     * 发货页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function express()
    {
        $id = $this->param('id', 'intval');

        $order = Order::find($id);

        $expressCfg = config('express');

        $expressList = $expressCfg['api_list'][$expressCfg['default']]['express'];

        $logistics = [];

        if ($order->delivery_type && $order->delivery_code) {

            $logistics = order_logistics_detail($order->delivery_type, $order->delivery_code);
        }

        return $this->view('admin.order.express', compact('order', 'expressList', 'logistics'));
    }

    /**
     * 物流发货
     * @param OrderDeliveryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delivery(OrderDeliveryRequest $request)
    {

        $result = false;
        $data = $request->validated();

        if ($id = $this->param('id', 'intval')) {

            $data['delivery_status'] = Order::DELIVERY_STATUS_FINISH;
            $data['delivery_time'] = time();
            $data['order_status'] = Order::ORDER_STATUS_WAIT_RECEIVE;

            $result = Order::where('id', $id)
                ->whereIn('order_status', [Order::ORDER_STATUS_WAIT_DELIVER, Order::ORDER_STATUS_WAIT_RECEIVE])
                ->update($data);
        }

        return $this->result($result);
    }

}
