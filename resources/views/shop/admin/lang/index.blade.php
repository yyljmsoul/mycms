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
            index_url: location.href,
            add_url: '/admin/shop/goods/lang/create?goods_id=' + myAdmin.getQueryParam('id'),
            edit_url: '/admin/shop/goods/lang/edit?goods_id=' + myAdmin.getQueryParam('id'),
            delete_url: '/admin/shop/goods/lang/destroy?goods_id=' + myAdmin.getQueryParam('id'),
        }, [
            {type: "checkbox"},
            {field: 'goods_name', minWidth: 80, title: '名称'},
            {field: 'lang_name', minWidth: 80, title: '语言'},
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
