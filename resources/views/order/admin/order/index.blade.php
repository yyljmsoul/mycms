@extends("layouts.common")
@section('page-content-wrapper')

    <div class="table-rep-plugin">

        <div class="btn-toolbar">
            <div class="button-items btn-group"></div>
            <div class="search-bar btn-group pull-right"></div>
        </div>
        <div class="table-responsive mb-0" data-pattern="priority-columns">
            <table id="currentTable" class="table table-striped">
            </table>
        </div>
    </div>
@endsection
@section('extend-javascript')
    <script>

        let orderStatus = ["待支付", "待发货", "待收货", "已完成", "已取消", "已退款"];

        myAdmin.table({
            table_elem: '#currentTable',
            index_url: '/admin/order',
            detail_url: '/admin/order/detail',
            express_url: '/admin/order/express',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'order_sn', minWidth: 80, title: '订单号', search: true},
            {field: 'user.name', minWidth: 80, title: '下单用户'},
            {field: 'order_amount', minWidth: 80, title: '订单金额'},
            {
                field: 'order_status', minWidth: 80, title: '订单状态', templet: function (data) {
                    return orderStatus[data.order_status];
                }
            },
            {field: 'receive_name', minWidth: 80, title: '收货人'},
            {field: 'receive_telephone', minWidth: 80, title: '收货电话'},
            {field: 'receive_address', minWidth: 80, title: '详细地址'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '详情',
                        url: '/admin/order/detail',
                        class: '',
                    }, {
                        text: '物流',
                        url: '/admin/order/express',
                        class: '',
                    }
                ]
            }
        ], []);
    </script>
@endsection
