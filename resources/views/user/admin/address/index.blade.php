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
            index_url: '/admin/user/address',
            add_url: '/admin/user/address/create',
            edit_url: '/admin/user/address/edit',
            delete_url: '/admin/user/address/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'user_id', minWidth: 80, title: '用户Id'},
            {field: 'user.name', minWidth: 80, title: '用户账号'},
            {field: 'name', minWidth: 80, title: '收货人'},
            {field: 'telephone', minWidth: 80, title: '联系电话'},
            {field: 'province.name', minWidth: 120, title: '省份'},
            {field: 'city.name', minWidth: 120, title: '城市'},
            {field: 'district.name', minWidth: 120, title: '区/县'},
            {field: 'address', minWidth: 120, title: '详细地址'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
