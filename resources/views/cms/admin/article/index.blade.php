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
            index_url: '/admin/cms',
            add_url: '/admin/cms/create',
            edit_url: '/admin/cms/edit',
            delete_url: '/admin/cms/destroy',
            tag_url: '/admin/cms/tags',
            modify_url: '/admin/cms/modify',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'title', minWidth: 80, title: '标题', search: true},
            {field: 'author', minWidth: 80, title: '作者', search: true},
            {field: 'category.name', minWidth: 80, title: '分类', search: true},
            {field: 'view', minWidth: 80, title: '浏览'},
            {
                field: 'status',
                title: '状态',
                width: 85,
                selectList: {0: '待发布', 1: '已发布'},
            },
            {field: 'created_at', minWidth: 120, title: '时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '标签',
                        url: '/admin/cms/tags',
                        class: '',
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
