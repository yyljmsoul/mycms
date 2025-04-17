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
            index_url: '/admin/mp/mp_article',
            add_url: '/admin/mp/mp_article/create',
            edit_url: '/admin/mp/mp_article/edit',
            delete_url: '/admin/mp/mp_article/destroy',
            preview_url: '/admin/mp/mp_article/preview',
        }, [
            {type: "checkbox"},
            {field: 'id', minWidth: 80, title: 'ID'},
            {field: 'title', minWidth: 80, title: '标题', search: true},
            {field: 'author', minWidth: 80, title: '作者'},

            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'updated_at', minWidth: 120, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '预览',
                        url: '/admin/mp/mp_article/preview',
                        class: '',
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
