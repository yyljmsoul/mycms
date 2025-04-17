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
            index_url: '/admin/mp/mp_code/{{request()->route()->parameter('id')}}',
            add_url: '/admin/mp/mp_code/{{request()->route()->parameter('id')}}/create',
            edit_url: '/admin/mp/mp_code/{{request()->route()->parameter('id')}}/edit',
            delete_url: '/admin/mp/mp_code/{{request()->route()->parameter('id')}}/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '名称'},
            {field: 'mp.name', minWidth: 80, title: '公众号'},
            {
                field: 'code_type', minWidth: 80, title: '二维码类型', callback: function (type) {
                    return type === 'forever' ? '永久' : '临时';
                }
            },
            {field: 'code_image', minWidth: 80, title: '二维码', type: 'image'},
            {field: 'reply_type', minWidth: 80, title: '回复类型'},
            {field: 'reply_content', minWidth: 80, title: '回复内容'},
            {field: 'reply_image', minWidth: 80, title: '回复图片', type: 'image'},
            {field: 'tag_id', minWidth: 80, title: '用户标签'},
            {field: 'subscribe_count', minWidth: 80, title: '关注人数'},
            {field: 'scan_count', minWidth: 80, title: '扫描次数'},
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
