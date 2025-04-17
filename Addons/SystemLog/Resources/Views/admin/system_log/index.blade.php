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
            index_url: '/admin/addon/system_log',
        }, [
            {field: 'id', minWidth: 80, title: '流水号'},
            {field: 'admin_id', minWidth: 80, title: '管理员ID'},
            {field: 'admin_name', minWidth: 80, title: '管理员名称'},
            {field: 'method', minWidth: 80, title: '请求方式'},
            {field: 'url', minWidth: 80, title: '请求URL'},
            {field: 'ip', minWidth: 120, title: 'ip地址'},
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '详情',
                        url: '/admin/addon/system_log/show',
                    },
                ]
            }
        ], []);
    </script>
@endsection
