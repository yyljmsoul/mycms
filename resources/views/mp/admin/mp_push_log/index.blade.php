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
            index_url: '/admin/mp/mp_push_log',
            add_url: '/admin/mp/mp_push_log/create',
            edit_url: '/admin/mp/mp_push_log/edit',
            delete_url: '/admin/mp/mp_push_log/destroy',
            preview_url: '/admin/mp/mp_push_log/preview',
            push_url: '/admin/mp/mp_push_log/push',
        }, [
            {type: "checkbox"},
            {field: 'id', minWidth: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '任务名称'},
            {field: 'article_id', minWidth: 80, title: '文章ID'},
            {field: 'appid', minWidth: 80, title: 'AppId'},
            {field: 'account.type', minWidth: 80, title: '发布平台'},
            {field: 'media_id', minWidth: 80, title: '素材ID'},

            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'updated_at', minWidth: 120, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '预览',
                        url: '/admin/mp/mp_push_log/preview',
                        class: '',
                    }, {
                        text: '推送',
                        url: '/admin/mp/mp_push_log/push',
                        class: '',
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
