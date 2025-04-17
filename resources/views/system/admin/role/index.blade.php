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
            index_url: '/admin/role',
            add_url: '/admin/role/create',
            edit_url: '/admin/role/edit',
            delete_url: '/admin/role/destroy',
            export_url: '/admin/role/export',
            modify_url: '/admin/role/modify',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'role_name', minWidth: 80, title: '权限名称'},
            {field: 'role_desc', minWidth: 80, title: '备注信息'},
            {field: 'created_at', minWidth: 80, title: '创建时间'},
            {field: 'updated_at', minWidth: 80, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    {
                        text: '授权',
                        url: '/admin/role/auth',
                        method: 'open',
                        auth: 'auth',
                        class: 'layui-btn layui-btn-normal layui-btn-xs',
                    },
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
