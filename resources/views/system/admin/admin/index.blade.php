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
            index_url: '/admin/admin',
            add_url: '/admin/admin/create',
            edit_url: '/admin/admin/edit',
            delete_url: '/admin/admin/destroy',
            modify_url: '/admin/admin/modify',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '登录账户', search: true},
            {field: 'role.role_name', minWidth: 80, title: '角色权限'},
            {field: 'login_num', minWidth: 80, title: '登录次数'},
            {field: 'remark', minWidth: 80, title: '备注信息'},
            {
                field: 'status',
                title: '状态',
                width: 85,
                selectList: {0: '禁用', 1: '启用'},
            },
            {field: 'last_login_time', minWidth: 80, title: '最后登录时间'},
            {field: 'last_login_ip', minWidth: 80, title: '最后登录IP'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'updated_at', minWidth: 120, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    {
                        text: '密码',
                        url: '/admin/admin/password',
                        method: 'open',
                        auth: 'password',
                        class: 'layui-btn layui-btn-normal layui-btn-xs',
                    },
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
