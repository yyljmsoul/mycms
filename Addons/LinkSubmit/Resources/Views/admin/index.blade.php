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
            index_url: '/admin/addon/link_submit',
            add_url: '/admin/addon/link_submit/create',
            config_url: '/admin/addon/link_submit/config',
        }, [
            {field: 'id', minWidth: 80, title: '流水号'},
            {field: 'admin_name', minWidth: 80, title: '管理员名称'},
            {field: 'url', minWidth: 80, title: '请求URL'},
            {field: 'respond', minWidth: 80, title: '响应'},
            {field: 'created_at', minWidth: 120, title: '时间'},
        ], ['add', 'config']);
    </script>
@endsection
