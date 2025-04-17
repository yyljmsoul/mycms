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
            index_url: '/admin/addon',
            modify_url: '/admin/addon/modify',
        }, [
            {field: 'name', minWidth: 80, title: '名称'},
            {field: 'ident', minWidth: 80, title: '标识'},
            {field: 'version', minWidth: 80, title: '版本'},
            {field: 'author', minWidth: 80, title: '作者'},
            /*{
                field: 'is_menu',
                selectList: {0: '否', 1: '是'},
                minWidth: 80,
                title: '显示到菜单'
            },*/
            {field: 'description', minWidth: 80, title: '描述'},
            {field: 'operation', minWidth: 120, title: '操作'},
        ], []);
    </script>
@endsection
