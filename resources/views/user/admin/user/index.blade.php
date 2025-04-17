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
            index_url: '/admin/user',
            add_url: '/admin/user/create',
            edit_url: '/admin/user/edit',
            delete_url: '/admin/user/destroy',
            modify_url: '/admin/user/modify',
            password_url: '/admin/user/password',
            account_url: '/admin/user/account',
            rank_url: '/admin/user/rank',
            address_url: '/admin/user/address',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '用户名', search: true},
            {field: 'mobile', minWidth: 80, title: '手机号', search: true},
            {field: 'img', minWidth: 80, title: '头像', type: 'image'},
            {
                field: 'user_rank.name', minWidth: 80, title: '会员等级'
            },
            {field: 'openid', minWidth: 80, title: 'openid'},
            {field: 'balance', minWidth: 80, title: '余额'},
            {field: 'point', minWidth: 80, title: '积分'},
            {
                field: 'status',
                title: '状态',
                width: 85,
                search: 'select',
                selectList: {0: '禁用', 1: '启用'},
            },
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    {
                        text: '重置密码',
                        url: '/admin/user/password',
                        class: '',
                    },
                    {
                        text: '资金变动',
                        url: '/admin/user/account',
                        class: '',
                    },
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
