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
            index_url: '/admin/mp/mp_reply/{{request()->route()->parameter('id')}}',
            add_url: '/admin/mp/mp_reply/{{request()->route()->parameter('id')}}/create',
            edit_url: '/admin/mp/mp_reply/edit',
            delete_url: '/admin/mp/mp_reply/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'mp.name', minWidth: 80, title: '公众号'},
            {
                field: 'type', minWidth: 80, title: '模式', callback: function (type) {
                    switch (type) {
                        case 'subscribe':
                            return '关注后回复';
                            break;
                        case 'accurate_match':
                            return '精准匹配';
                            break;
                        case 'fuzzy_match':
                            return '模糊匹配';
                            break;
                    }
                }
            },
            {field: 'keyword', minWidth: 80, title: '关键词'},
            {
                field: 'reply_type', minWidth: 80, title: '回复类型', callback: function (reply_type) {
                    switch (reply_type) {
                        case 'content':
                            return '文本';
                            break;
                        case 'image':
                            return '图片';
                            break;
                    }
                }
            },
            {
                field: 'reply_content', minWidth: 80, title: '回复内容', callback: function (reply_content) {
                    return reply_content.substring(0, 10);
                }
            },
            {field: 'reply_image', minWidth: 80, title: '回复图片', type: 'image'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
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
