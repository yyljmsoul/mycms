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
            index_url: '/admin/shop/category',
            add_url: '/admin/shop/category/create',
            edit_url: '/admin/shop/category/edit',
            delete_url: '/admin/shop/category/destroy',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'name', minWidth: 80, title: '名称', search: true},
            {
                field: 'parent.name', minWidth: 80, title: '父级', templet: function (d) {
                    return d.parent ? d.parent.name : '无';
                }
            },
            {field: 'description', minWidth: 80, title: '描述'},
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
