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
            index_url: '/admin/mp/mp_user/{{request()->route()->parameter('id')}}',
            add_url: '/admin/mp/mp_user/{{request()->route()->parameter('id')}}/create',
            edit_url: '/admin/mp/mp_user/{{request()->route()->parameter('id')}}/edit',
            delete_url: '/admin/mp/mp_user/{{request()->route()->parameter('id')}}/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'openid', minWidth: 80, title: 'openid'},
            {field: 'unionid', minWidth: 80, title: 'unionid'},
            {field: 'tags', minWidth: 80, title: '标签'},
            {field: 'subscribe_scene', minWidth: 80, title: '关注来源'},
            {field: 'qr_scene', minWidth: 80, title: '二维码来源'},
            {field: 'subscribe_time', minWidth: 80, title: '关注时间'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
        ], []);
    </script>
@endsection
