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
            index_url: '/admin/api/data_source',
            add_url: '/admin/api/data_source/create',
            edit_url: '/admin/api/data_source/edit',
            delete_url: '/admin/api/data_source/destroy',
        }, [
            {type: "checkbox"},
            {field: 'name', minWidth: 80, title: '表名'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    {
                        text: '数据管理',
                        url : '{{route('api.data_manage.index')}}',
                        class:'btn btn-success',
                        target: '_blank',
                        param_key: 'table'
                    }
                ]
            }
        ], ['add']);
    </script>
@endsection
