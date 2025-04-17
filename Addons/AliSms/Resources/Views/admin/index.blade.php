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
            index_url: '/admin/addon/alisms',
            add_url: '/admin/addon/alisms/create',
            edit_url: '/admin/addon/alisms/edit',
            delete_url: '/admin/addon/alisms/destroy',
        }, [
            {field: 'id', minWidth: 80, title: '序号'},
            {field: 'access_key', minWidth: 80, title: 'AccessKey'},
            {field: 'access_secret', minWidth: 80, title: 'AccessSecret'},
            {field: 'sign_name', minWidth: 80, title: '短信签名'},
            {field: 'template_code', minWidth: 80, title: '短信模板'},
            {
                field: 'is_default', minWidth: 80, title: '默认', selectList: {0: "否", 1: "是"}
            },
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '发送记录',
                        url: '/admin/addon/alisms/logs',
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
