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
            index_url: '/admin/api/api_project',
            add_url: '/admin/api/api_project/create',
            edit_url: '/admin/api/api_project/edit',
            delete_url: '/admin/api/api_project/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '项目名称'},
            {field: 'description', minWidth: 80, title: '项目描述'},
            {field: 'ident', minWidth: 80, title: '项目key'},

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
