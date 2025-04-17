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
            index_url: '/admin/mp/mp_template',
            add_url: '/admin/mp/mp_template/create',
            edit_url: '/admin/mp/mp_template/edit',
            delete_url: '/admin/mp/mp_template/destroy',
            preview_url: '/admin/mp/mp_template/preview',
            make_url: '/admin/mp/mp_template/make',
        }, [
            {type: "checkbox"},
            {field: 'name', minWidth: 80, title: '名称'},
            {field: 'description', minWidth: 80, title: '备注'},
            {field: 'created_at', minWidth: 120, title: '创建时间'},
            {field: 'updated_at', minWidth: 120, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    {
                        text: '预览文章',
                        url: '/admin/mp/mp_template/preview',
                        class: '',
                    }, {
                        text: '生成文章',
                        title: '确定生成文章？',
                        url: '/admin/mp/mp_template/make',
                        class: '',
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);
    </script>
@endsection
