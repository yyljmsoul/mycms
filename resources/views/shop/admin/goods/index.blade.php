@extends("layouts.common")
@section('page-content-wrapper')
    <script>
        var systemLang = {!! json_encode(array_keys(system_tap_lang() ?: [])) !!};
    </script>
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
            index_url: '/admin/shop/goods',
            add_url: '/admin/shop/goods/create',
            edit_url: '/admin/shop/goods/edit',
            delete_url: '/admin/shop/goods/destroy',
            lang_url: '/admin/shop/goods/lang',
        }, [
            {type: "checkbox"},
            {field: 'id', width: 80, title: '序号'},
            {field: 'goods_name', minWidth: 80, title: '名称', search: true},
            {field: 'goods_image', minWidth: 80, title: '主图', type: 'image'},
            {field: 'category.name', minWidth: 80, title: '分类', search: true},
            {field: 'shop_price', minWidth: 80, title: '价格'},
            {field: 'market_price', minWidth: 80, title: '市场价'},
            {field: 'stock', minWidth: 80, title: '库存'},
            {field: 'view', minWidth: 80, title: '浏览数'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    'delete',
                    {
                        text: '多语言管理',
                        url: '/admin/shop/goods/lang',
                        class: '',
                    }
                ]
            }
        ]);
    </script>
@endsection
