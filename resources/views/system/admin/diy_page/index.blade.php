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
            index_url: '/admin/diy-page',
            add_url: '/admin/diy-page/create',
            edit_url: '/admin/diy-page/edit',
            delete_url: '/admin/diy-page/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'page_name', minWidth: 80, title: '页面名称'},
            {field: 'page_path', minWidth: 80, title: '页面地址'},
            {field: 'page_title', minWidth: 80, title: '页面标题'},
            {field: 'page_keyword', minWidth: 80, title: '页面关键词'},
            {field: 'page_desc', minWidth: 80, title: '页面描述'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'updated_at', minWidth: 120, title: '更新时间'},
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
