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
        myAdmin.table({
            table_elem: '#currentTable',
            index_url: '/admin/shop/pay/logs',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'trade_no', minWidth: 80, title: '支付单号', search: true},
            {field: 'user.name', minWidth: 80, title: '用户', search: true},
            {field: 'goods_name', minWidth: 80, title: '商品'},
            {field: 'total_amount', minWidth: 80, title: '金额'},
            {
                field: 'status', minWidth: 80, title: '状态', templet: function (d) {
                    return d.status == 1 ? '<span style="color: green">是</span>' : '<span style="color: red">否</span>';
                }
            },
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'pay_time', minWidth: 80, title: '支付时间'}
        ], []);
    </script>
@endsection
