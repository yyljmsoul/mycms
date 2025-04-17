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
            index_url: '/admin/cms/comment',
            modify_url: '/admin/cms/comment/modify',
            config_url: '/admin/cms/comment/config',
            delete_url: '/admin/cms/comment/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'user.name', minWidth: 80, title: '用户', search: true},
            {field: 'content', minWidth: 80, title: '内容'},
            {
                field: 'status',
                minWidth: 80,
                title: '状态',
                selectList: {0: '待审核', 1: '已通过'},
            },
            {field: 'single_id', minWidth: 120, title: '文章ID', search: true},
            {field: 'article.title', minWidth: 120, title: '文章'},
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'delete'
                ]
            }
        ], ['config', 'delete']);
    </script>
@endsection
