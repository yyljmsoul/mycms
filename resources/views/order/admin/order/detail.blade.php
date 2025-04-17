@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">基本信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#goods" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">商品信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#address" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">收货信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#express" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">物流信息</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#pay" role="tab">
                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                    <span class="d-none d-sm-block">支付信息</span>
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="base" role="tabpanel">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td>下单用户</td>
                        <td>{{$order->user->name}}</td>
                    </tr>
                    <tr>
                        <td>订单号</td>
                        <td>{{$order->order_sn}}</td>
                    </tr>
                    <tr>
                        <td>订单总额</td>
                        <td>{{$order->order_amount}}</td>
                    </tr>
                    <tr>
                        <td>商品总额</td>
                        <td>{{$order->goods_money}}</td>
                    </tr>
                    <tr>
                        <td>订单状态</td>
                        <td>{{order_status_text($order->order_status)}}</td>
                    </tr>
                    <tr>
                        <td>创建时间</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                    <tr>
                        <td>更新时间</td>
                        <td>{{$order->updated_at}}</td>
                    </tr>
                    <tr>
                        <td>订单备注</td>
                        <td>{{$order->remark}}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="tab-pane" id="goods" role="tabpanel">

                <table class="table table-striped">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>商品ID</th>
                        <th>商品名称</th>
                        <th>下单单价</th>
                        <th>下单数量</th>
                        <th>下单总额</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->goods as $goods)
                        <tr>
                            <td>{{$goods->goods_id}}</td>
                            <td>{{$goods->goods_name}}</td>
                            <td>{{$goods->shop_price}}</td>
                            <td>{{$goods->number}}</td>
                            <td>{{$goods->goods_money}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane" id="address" role="tabpanel">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td>收货人</td>
                        <td>{{$order->receive_name}}</td>
                    </tr>
                    <tr>
                        <td>联系电话</td>
                        <td>{{$order->receive_telephone}}</td>
                    </tr>
                    <tr>
                        <td>省/市/县</td>
                        <td>{{$order->province->name}} {{$order->city->name}} {{$order->district->name}}</td>
                    </tr>
                    <tr>
                        <td>详细地址</td>
                        <td>{{$order->receive_address}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="express" role="tabpanel">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td>发货状态</td>
                        <td>{{delivery_status_text($order->delivery_status)}}</td>
                    </tr>
                    <tr>
                        <td>发货时间</td>
                        <td>{{$order->delivery_time ? date('Y-m-d H:i:s',$order->delivery_time) : '无'}}</td>
                    </tr>
                    <tr>
                        <td>快递费用</td>
                        <td>{{$order->delivery_money}}</td>
                    </tr>
                    <tr>
                        <td>快递类型</td>
                        <td>{{express_type_to_text($order->delivery_type)}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="pay" role="tabpanel">

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td>支付状态</td>
                        <td>{{pay_status_text($order->pay_status)}}</td>
                    </tr>
                    <tr>
                        <td>支付时间</td>
                        <td>{{$order->pay_time ? date('Y-m-d H:i:s',$order->pay_time) : '无'}}</td>
                    </tr>
                    <tr>
                        <td>支付方式</td>
                        <td>{{pay_type_to_text($order->pay_type)}}</td>
                    </tr>
                    <tr>
                        <td>支付流水</td>
                        <td>{{$order->out_trade_no}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
