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
            index_url: '/admin/addon/msg_board',
            edit_url: '/admin/addon/msg_board/edit',
            delete_url: '/admin/addon/msg_board/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'first_name', minWidth: 80, title: '姓'},
            {field: 'last_name', minWidth: 80, title: '名'},
            {field: 'email', minWidth: 80, title: 'Email'},
            {field: 'phone', minWidth: 80, title: '手机号码'},
            {field: 'subject', minWidth: 80, title: '主题'},
            {field: 'content', minWidth: 80, title: '内容'},
            {
                field: 'status', minWidth: 80, title: '状态', callback: function (status) {
                    return status === 1 ? '<span style="color: green">已处理</span>' : '<span style="color: red">待处理</span>';
                }
            },
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    'delete'
                ]
            }
        ], ['delete']);
    </script>
@endsection
