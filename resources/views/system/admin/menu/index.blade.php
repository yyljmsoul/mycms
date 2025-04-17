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
            index_url: '/admin/menu',
            add_url: '/admin/menu/create',
            delete_url: '/admin/menu/destroy',
            edit_url: '/admin/menu/edit',
            modify_url: '/admin/menu/modify',
            config_url: '/admin/menu/config',
        }, [
            {type: 'checkbox'},
            {field: 'title', width: 250, title: '菜单名称'},
            {field: 'url', minWidth: 120, title: '菜单链接'},
            {field: 'parent.title', minWidth: 120, title: '上级菜单'},
            {field: 'icon', width: 80, title: '图标'},
            {field: 'sort', width: 80, title: '排序'},
            {
                field: 'status',
                width: 80,
                search: 'select',
                title: '显示状态',
                selectList: {0: '隐藏', 1: '显示'},
            },
            {
                width: 200,
                title: '操作',
                operate: [
                    function (data) {
                        return '<a href="javascript:" onclick="copyMenu(' + data.id + ')" class="mx-1 btn btn-sm btn-success waves-effect waves-light">复制</a>';
                    },
                    'edit',
                    'delete'
                ]
            }
        ]);

        function copyMenu(id) {
            const url = '{{route('system.menu.copy')}}';
            myAdmin.request.post(url, {id}, function (data) {
                if (data.code === 200) {
                    myAdmin.message.success(data.msg, function () {
                        location.reload();
                    });
                } else {
                    myAdmin.message.error(data.msg);
                }
            })
        }
    </script>
@endsection
