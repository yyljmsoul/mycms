@extends("layouts.base")

@section('container-fluid')
    <div class="container-fluid">
        <div class="page-content-wrapper">


            <div class="row">

                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">今日订单</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-primary">
                                                                <i class="mdi mdi-cart-outline text-primary font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['order_today_count']}}
                                            / {{$data['order_today_total']}}</h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">新增用户</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-success">
                                                                <i class="mdi mdi-account-outline text-success font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['user_today']}}</h5>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">订单总数</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-primary">
                                                                <i class="dripicons-shopping-bag text-primary font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['order_count']}}
                                            / {{$data['order_total']}}</h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">用户总数</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-success">
                                                                <i class="dripicons-user-group text-success font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['user_count']}}</h5>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">商品总数</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-primary">
                                                                <i class="dripicons-store text-primary font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['goods_count']}}</h5>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <p class="font-size-16">文章总数</p>
                                        <div class="mini-stat-icon mx-auto mb-4 mt-3">
                                                        <span class="avatar-title rounded-circle bg-soft-success">
                                                                <i class="dripicons-document text-success font-size-20"></i>
                                                            </span>
                                        </div>
                                        <h5 class="font-size-22">{{$data['article_count']}}</h5>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">最近下单</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>订单ID</th>
                                        <th>商品</th>
                                        <th>下单用户</th>
                                        <th>收货人</th>
                                        <th>金额</th>
                                        <th>状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>
                                                @foreach($order->goods as $goods)
                                                    {{$goods->goods_name}}
                                                    @break
                                                @endforeach
                                                @if($order->goods->count() > 1)
                                                    等{{$order->goods->count()}}样商品
                                                @endif
                                            </td>
                                            <td>{{$order->user ? $order->user->name : ''}}</td>
                                            <td>{{$order->receive_name}}</td>
                                            <td>{{$order->order_amount}}</td>
                                            <td><span
                                                    class="font-size-13">{{order_status_text($order->order_status)}}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4">热销商品</h4>
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>商品ID</th>
                                        <th>商品名称</th>
                                        <th>销量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($goodsTop as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->goods_name}}</td>
                                            <td>{{$item->sales}}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection
