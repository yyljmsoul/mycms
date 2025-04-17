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
            index_url: '/admin/system_config',
            add_url: '/admin/system_config/create',
            edit_url: '/admin/system_config/edit',
            delete_url: '/admin/system_config/destroy',
        }, [
            {type: "checkbox"},
            {field: 'cfg_key', minWidth: 80, title: '配置标识'},
            {field: 'cfg_val', minWidth: 80, title: '配置值'},
            {field: 'cfg_group', minWidth: 80, title: '配置分组'},

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
