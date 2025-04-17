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
            index_url: '/admin/addon/directmail',
            add_url: '/admin/addon/directmail/create',
            edit_url: '/admin/addon/directmail/edit',
            delete_url: '/admin/addon/directmail/destroy',
        }, [
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'access_key', minWidth: 80, title: 'AccessKey'},
            {field: 'access_secret', minWidth: 80, title: 'AccessSecret'},
            {field: 'account_name', minWidth: 80, title: '发信地址'},
            {field: 'region', minWidth: 80, title: '发信地域'},
            {field: 'alias', minWidth: 80, title: '发信别名'},
            {
                field: 'is_default', minWidth: 80, title: '默认', selectList: {0: "否", 1: "是"}
            },
            {field: 'remark', minWidth: 80, title: '备注'},
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
