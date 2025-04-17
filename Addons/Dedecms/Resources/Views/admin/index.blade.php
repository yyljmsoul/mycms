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
            index_url: '/admin/addon/dede',
            config_url: '/admin/addon/dede/config',
        }, [
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'type', minWidth: 80, title: '类型'},
            {field: 'oid', minWidth: 80, title: '原ID'},
            {field: 'mid', minWidth: 80, title: '新ID'},
            {field: 'title', minWidth: 80, title: '标题'},
            {field: 'created_at', minWidth: 120, title: '时间'},
        ], ['config',
            {
                text: '导入文章',
                url: '/admin/addon/dede/import/article',
                class : 'btn btn-success ajaxRequest'
            }, {
                text: '导入商品',
                url: '/admin/addon/dede/import/goods',
                class : 'btn btn-primary ajaxRequest'
            }]);
    </script>
@endsection
