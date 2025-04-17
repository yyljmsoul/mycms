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
            index_url: '/admin/cms/article_group',
            add_url: '/admin/cms/article_group/create',
            edit_url: '/admin/cms/article_group/edit',
            delete_url: '/admin/cms/article_group/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '分组名称'},
            {field: 'category.name', minWidth: 80, title: '分类名称'},
            {field: 'sort', minWidth: 80, title: '排序'},

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
