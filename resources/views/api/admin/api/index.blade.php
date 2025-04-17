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
            index_url: '/admin/api',
            add_url: '/admin/api/create',
            edit_url: '/admin/api/edit',
            delete_url: '/admin/api/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: 'ID'},
            {field: 'name', minWidth: 80, title: '名称'},
            {field: 'path', minWidth: 80, title: '地址'},
            {field: 'method', minWidth: 80, title: '方法'},
            {
                field: 'source_type', minWidth: 80, title: '数据源', callback: function (value) {
                    switch (value) {
                        case 'request':
                            return '转发请求';
                            break;
                        case 'content':
                            return '自定义内容';
                            break;
                        case 'table':
                            return '数据表';
                            break;
                        case 'diy':
                            return '自定义';
                            break;
                    }
                }
            },

            {field: 'use_count', minWidth: 120, title: '次数'},
            {field: 'created_at', minWidth: 120, title: '创建'},
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
