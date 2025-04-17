<?php

namespace Modules\Api\Http\Controllers;

use Expand\Pay\Pay;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Api\Http\Requests\OrderSubmitRequest;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderGoods;
use Modules\Shop\Models\Cart;
use Modules\Shop\Models\Goods;

class OrderController extends ApiController
{
    /**
     * 购物车结算
     * @return JsonResponse
     */
    public function cartSettle(): JsonResponse
    {
        $uid = $this->getUserId();
        $cartIds = json_decode($this->param('cart_ids'), true);

        if ($cartIds) {

            $goodsList = [];

            $carts = Cart::with('goods:id,goods_name,goods_image,shop_price,market_price')
                ->whereIn('id', $cartIds)
                ->where('user_id', $uid)
                ->get()
                ->toArray();

            foreach ($carts as $cart) {

                $goods = $this->objectFilterField($cart['goods'], ['id'], true);

                $goodsList[] = array_merge($goods, [
                    'id' => $cart['id'],
                    'goods_id' => $cart['goods_id'],
                    'number' => $cart['number'],
                    'goods_image' => system_image_url($goods['goods_image']),
                    'total' => $cart['number'] * $goods['shop_price']
                ]);

            }

            $result = [
                'result' => [
                    'total' => array_sum(array_column($goodsList, 'total')),
                    'goodsList' => $goodsList,
                ]
            ];

            return $this->success($result);
        }

        return $this->error(['msg' => '请选择结算商品']);

    }

    /**
     * 商品直接购买
     * @return JsonResponse
     */
    public function directSettle(): JsonResponse
    {
        $goodsId = $this->param('goods_id', 'intval');
        $number = $this->param('number', 'intval');

        if ($goodsId && $number) {

            if (app('store')->checkGoodsStock($goodsId, $number) == false) {

                return $this->error(['msg' => "商品库存不足"]);
            }

            $goods = Goods::find($goodsId)->toArray();

            if (!$goods) {

                return $this->error(['msg' => "商品不存在"]);
            }

            $goods = $this->objectFilterField($goods, ['goods_name', 'goods_image', 'shop_price', 'market_price']);

            $result = [
                'result' => [
                    'total' => $goods['shop_price'] * $number,
                    'goodsList' => [
                        array_merge($goods, [
                            'total' => $goods['shop_price'] * $number,
                            'goods_id' => $goodsId,
                            'goods_image' => system_image_url($goods['goods_image'])
                        ])
                    ],
                ]
            ];

            return $this->success($result);
        }

        return $this->error(['msg' => '请选择结算商品']);
    }


    /**
     * 提交订单
     * @param OrderSubmitRequest $request
     * @return JsonResponse
     */
    public function submit(OrderSubmitRequest $request): JsonResponse
    {

        $uid = $this->getUserId();
        $data = $request->validated();

        $params = json_decode($data['param_json'], true);

        if ($params) {

            $cartIds = array_column($params, 'cart_id');

            if ($cartIds) {

                $carts = app('store')->cart($uid, $cartIds);

                if ($carts->count() == 0) {

                    return $this->error(['msg' => '购物车里没有该商品']);
                }
            }

            foreach ($params as &$param) {

                $param['sku_id'] = $param['sku_id'] ?? 0;

                if ($param['goods_id'] && $param['number']) {

                    $stock = app('store')->checkGoodsStock($param['goods_id'], $param['number'], $param['sku_id']);

                    if (!$stock) {

                        return $this->error(['msg' => "商品库存不足"]);
                    }


                    $goods = Goods::find($param['goods_id']);

                    $param['sku_val'] = '';
                    $param['goods_name'] = $goods->goods_name;
                    $param['goods_image'] = $goods->goods_image;
                    $param['market_price'] = $goods->market_price;
                    $param['shop_price'] = $goods->shop_price;


                    if ($param['sku_id'] > 0) {

                        $sku = app('store')->getGoodsSkuInfo($param['goods_id'], $param['sku_id']);

                        $param['sku_val'] = $sku->spec_name;
                        $param['goods_image'] = $sku->img ?: $goods->goods_image;
                        $param['market_price'] = $sku->market_price;
                        $param['shop_price'] = $sku->shop_price;
                    }

                    $param['total'] = $param['number'] * $param['shop_price'];

                }
            }

            $address = app('user')->address($data['address_id'], $uid);

            if (!$address) {

                return $this->error(['msg' => '收货地址不存在']);
            }

            DB::beginTransaction();

            $goodsMoney = array_sum(array_column($params, 'total'));
            $freight = app('store')->freightTotal($goodsMoney);

            $order = [
                'user_id' => $uid,
                'order_sn' => app('store')->makeOrderSn(),
                'out_trade_no' => '',
                'order_amount' => $goodsMoney + $freight,
                'goods_money' => $goodsMoney,
                'delivery_money' => $freight,
                'order_status' => Order::ORDER_STATUS_WAIT_PAY,
                'pay_status' => Order::PAY_STATUS_WAIT,
                'delivery_status' => Order::DELIVERY_STATUS_WAIT,
                'pay_type' => '',
                'delivery_type' => '',
                'delivery_code' => '',
                'receive_name' => $address->name,
                'receive_telephone' => $address->telephone,
                'receive_province' => $address->province_id,
                'receive_city' => $address->city_id,
                'receive_district' => $address->district_id,
                'receive_address' => $address->address,
                'create_time' => time(),
                'pay_time' => 0,
                'delivery_time' => 0,
                'close_time' => 0,
                'remark' => $data['remark'] ?? '',
            ];

            $orderId = Order::insert($order);

            foreach ($params as $item) {

                $orderGoods = [
                    'order_id' => $orderId,
                    'user_id' => $uid,
                    'goods_id' => $item['goods_id'],
                    'goods_name' => $item['goods_name'],
                    'goods_image' => $item['goods_image'],
                    'market_price' => $item['market_price'],
                    'shop_price' => $item['shop_price'],
                    'number' => $item['number'],
                    'sku_id' => $item['sku_id'],
                    'sku_val' => $item['sku_val'],
                    'goods_money' => $item['number'] * $item['shop_price'],
                ];

                OrderGoods::insert($orderGoods);

                app('store')->reduceGoodsStock($item['goods_id'], $item['number'], $item['sku_id']);
            }

            if ($orderId) {

                if ($cartIds) {

                    Cart::whereIn('id', $cartIds)->delete();
                }

                DB::commit();

                return $this->success(['order_sn' => $order['order_sn']]);

            } else {

                DB::rollBack();

                return $this->error();
            }
        }

        return $this->error(['msg' => '请选择结算商品']);
    }


    /**
     * 用户订单列表
     * @return JsonResponse
     */
    public function orders(): JsonResponse
    {
        $uid = $this->getUserId();
        $status = $this->param('status');
        $status = $status === '' || intval($status) < 0 ? false : intval($status);
        $page = $this->param('page', 'intval', 1);
        $limit = $this->param('limit', 'intval', 10);

        $result = [];
        $orders = app('order')->userOrders($uid, $status, $page, $limit);

        if ($orders) {

            $result = $this->pageFilterField($orders);
            $result['data'] = [];

            foreach ($orders as $item) {

                $item = app('order')->formatOrder($item);

                $result['data'][] = $this->objectFilterField($item, [
                    'updated_at', 'created_at'
                ], true);
            }
        }

        return $this->success(['result' => $result]);
    }


    /**
     * 订单详情
     * @param $orderSn
     * @return JsonResponse
     */
    public function orderDetail($orderSn): JsonResponse
    {
        $result = [];
        $uid = $this->getUserId();

        $order = Order::with([
            'goods',
            'province:id,name',
            'city:id,name',
            'district:id,name'
        ])->where('order_sn', $orderSn)
            ->where('user_id', $uid)
            ->first();

        if ($order) {

            if ($order->delivery_status > 0) {

                $order->logistics = order_logistics_detail($order->delivery_type, $order->delivery_code);
            }

            $result = app('order')->formatOrder($order);
        }

        return $this->success(['result' => $result]);
    }

    /**
     * 订单完成
     * @param $orderSn
     * @return JsonResponse
     */
    public function finish($orderSn): JsonResponse
    {
        $uid = $this->getUserId();

        $order = Order::where('order_sn', $orderSn)->where('user_id', $uid)->first();

        if ($order && $order->order_status == Order::ORDER_STATUS_WAIT_RECEIVE) {

            $order->order_status = Order::ORDER_STATUS_FINISH;
            $order->finish_time = time();
            $order->save();

            return $this->success(['msg' => '订单完成']);
        }

        return $this->error(['msg' => '订单确认失败，请检查订单信息']);
    }


    /**
     * 取消订单
     * @param $orderSn
     * @return JsonResponse
     */
    public function cancel($orderSn): JsonResponse
    {
        $uid = $this->getUserId();

        $order = Order::where('order_sn', $orderSn)->where('user_id', $uid)->first();

        if ($order && in_array($order->order_status, [Order::ORDER_STATUS_WAIT_PAY, Order::ORDER_STATUS_WAIT_DELIVER])) {

            if ($order->order_status == Order::ORDER_STATUS_WAIT_DELIVER) {

                $pay = new Pay($order->pay_type);
                $pay->refund($order->toArray());

                $order->order_status = Order::ORDER_STATUS_REFUND;

            } else {

                $order->order_status = Order::ORDER_STATUS_CANCEL;
            }

            $order->close_time = time();
            $order->save();

            return $this->success(['msg' => '订单取消成功']);
        }

        return $this->error(['msg' => '订单取消失败']);
    }
}
