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
            index_url: '/admin/user/rank',
            add_url: '/admin/user/rank/create',
            edit_url: '/admin/user/rank/edit',
            delete_url: '/admin/user/rank/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'name', minWidth: 80, title: '等级名称'},
            {field: 'number', minWidth: 80, title: '等级编码'},
            {field: 'description', minWidth: 80, title: '备注信息'},
            {field: 'created_at', minWidth: 120, title: '变动时间'},
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
