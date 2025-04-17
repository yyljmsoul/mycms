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
        let init = {
            table_elem: '#currentTable',
            index_url: '/admin/api/data_manage',
            add_url: '/admin/api/data_manage/create',
            edit_url: '/admin/api/data_manage/edit',
            delete_url: '/admin/api/data_manage/destroy?table={{request()->input('table')}}',
        };

        myAdmin.table(init, [
            {type: "checkbox"},
                @foreach($columns as $col)
            {
                field: '{{$col['name']}}', minWidth: 80, title: '{{$col['comment'] ?: $col['name']}}'
            },
                @endforeach
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    'delete'
                ]
            }
        ], ['add', 'delete'], 1, {table: '{{request()->input('table')}}'});
    </script>
@endsection
