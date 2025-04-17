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
            index_url: '/admin/addon/friend_link',
            add_url: '/admin/addon/friend_link/create',
            edit_url: '/admin/addon/friend_link/edit',
            delete_url: '/admin/addon/friend_link/destroy',
            config_url: '/admin/addon/friend_link/config',
        }, [
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'name', minWidth: 80, title: '名称'},
            {field: 'url', minWidth: 80, title: 'URL'},
            {field: 'target', minWidth: 80, title: '打开方式'},
            {field: 'sort', minWidth: 80, title: '排序'},
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    'delete'
                ]
            }
        ], ['add', 'delete', 'config']);
    </script>
@endsection
