<?php

namespace Modules\Order\Service;

use App\Service\MyService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;

class OrderService extends MyService
{

    /**
     * 获取用户订单列表
     * @param $uid
     * @param bool $status
     * @param int $page
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function userOrders($uid, $status = false, $page = 1, $limit = 10): LengthAwarePaginator
    {
        $query = Order::with('goods')
            ->where('user_id', $uid);

        if ($status !== false) {

            $query = $query->where('order_status', $status);
        }

        return $query->orderBy('id', 'desc')
            ->paginate($limit, '*', 'page', $page);

    }

    /**
     * 格式化订单状态、时间
     * @param $order
     * @return mixed
     */
    public function formatOrder($order)
    {
        if (isset($order->order_status)) {
            $order->order_status_format = Order::ORDER_STATUS_TEXT[$order->order_status];
        }

        if (isset($order->pay_status)) {
            $order->pay_status_format = Order::PAY_STATUS_TEXT[$order->pay_status];
        }

        if (isset($order->delivery_status)) {
            $order->delivery_status_format = Order::DELIVERY_STATUS_TEXT[$order->delivery_status];
        }

        foreach (['create_time', 'pay_time', 'delivery_time', 'close_time', 'finish_time'] as $time) {

            if (isset($order->{$time})) {

                $order->{$time . "_format"} = $order->{$time} ? date('Y-m-d H:i:s', $order->{$time}) : '';
            }
        }

        if (isset($order->pay_type)) {

            $order->pay_type_format = $order->pay_type ?
                (config('pay.pay_list')[$order->pay_type]['name'] ?? '') : '';
        }

        if (isset($order->delivery_type)) {

            $expressCfg = config('express');
            $expressList = $expressCfg['api_list'][$expressCfg['default']]['express'];

            $order->delivery_type_format = $order->delivery_type ? $expressList[$order->delivery_type] : '';
        }

        return $order;
    }


    /**
     * 用户订单统计
     * @param $uid
     * @return mixed
     */
    public function orderCount($uid)
    {
        return Order::where('user_id', $uid)
            ->groupBy('order_status')
            ->select(['order_status', DB::raw('count(*) as count')])
            ->get()->toArray();
    }

}
