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
            index_url: '/admin/mp/mp_material/{{request()->route()->parameter('id')}}',
            add_url: '/admin/mp/mp_material/{{request()->route()->parameter('id')}}/create',
            edit_url: '/admin/mp/mp_material/edit',
            delete_url: '/admin/mp/mp_material/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'url', minWidth: 80, title: '素材地址', type: 'image'},
            {field: 'media_id', minWidth: 80, title: '素材ID'},

            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'delete'
                ]
            }
        ], ['delete']);
    </script>
@endsection
