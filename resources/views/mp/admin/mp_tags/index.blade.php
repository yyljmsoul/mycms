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
            index_url: '/admin/mp/mp_tags/{{request()->route()->parameter('id')}}',
            add_url: '/admin/mp/mp_tags/{{request()->route()->parameter('id')}}/create',
            edit_url: '/admin/mp/mp_tags/{{request()->route()->parameter('id')}}/edit',
            delete_url: '/admin/mp/mp_tags/{{request()->route()->parameter('id')}}/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '标签名称'},
            {field: 'count', minWidth: 80, title: '用户数量'},
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
