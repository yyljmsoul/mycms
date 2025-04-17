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
            index_url: '/admin/user/balance',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'user_id', minWidth: 80, title: '用户ID', search: true},
            {field: 'user.name', minWidth: 80, title: '用户名', search: true},
            {field: 'before', minWidth: 80, title: '变动前'},
            {field: 'balance', minWidth: 80, title: '变动金额'},
            {field: 'after', minWidth: 80, title: '变动后'},
            {field: 'description', minWidth: 80, title: '备注信息'},
            {field: 'created_at', minWidth: 120, title: '变动时间'},
        ], []);
    </script>
@endsection
