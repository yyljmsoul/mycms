@extends("layouts.common")
@section('page-content-wrapper')
    <script>
        var mps = {!! json_encode(config('mp.platform')) !!};
    </script>
    <div class="table-rep-plugin">

        <div class="btn-toolbar">
            <div class="button-items btn-group"></div>
            <div class="search-bar btn-group pull-right"></div>
        </div>
        <div class="table-responsive mb-0" data-pattern="priority-columns" style="min-height: 300px">
            <table id="currentTable" class="table table-striped">
            </table>
        </div>
    </div>
    <div id="more-tpl" style="display: none">
        <div class="btn-group mx-1">
            <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">更多 <i class="mdi mdi-chevron-down"></i></button>
            <div class="dropdown-menu">
                @if(admin_has_auth("/admin/mp/mp_user/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_user/id202306">用户列表</a> @endif
                @if(admin_has_auth("/admin/mp/mp_menu/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_menu/id202306">菜单设置</a> @endif
                @if(admin_has_auth("/admin/mp/mp_reply/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_reply/id202306">回复设置</a> @endif
                @if(admin_has_auth("/admin/mp/mp_material/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_material/id202306">素材管理</a> @endif
                @if(admin_has_auth("/admin/mp/mp_tags/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_tags/id202306">用户标签</a> @endif
                @if(admin_has_auth("/admin/mp/mp_code/{id}")) <a class="dropdown-item" target="_blank" href="/admin/mp/mp_code/id202306">渠道码</a> @endif
            </div>
        </div>
    </div>
    <div id="copy-tpl" style="display: none">
        <a href="javascript:" data-text="{{system_http_domain()}}/wechat/server/ident202306"
           class="mx-1 btn btn-sm btn-info waves-effect waves-light copy-btn">复制地址</a>
    </div>
@endsection
@section('extend-javascript')
    <script>

        myAdmin.table({
            table_elem: '#currentTable',
            index_url: '/admin/mp/mp_account',
            add_url: '/admin/mp/mp_account/create',
            edit_url: '/admin/mp/mp_account/edit',
            delete_url: '/admin/mp/mp_account/destroy',
        }, [
            {type: "checkbox"},
            {field: 'name', minWidth: 80, title: '名称'},
            {
                field: 'type', minWidth: 80, title: '平台类型', callback: function (item) {
                    //return mps[item.type];
                    return "微信公众号";
                }
            },
            {field: 'app_id', minWidth: 80, title: 'AppId'},
            //{field: 'app_key', minWidth: 80, title: 'AppKey'},

            {field: 'created_at', minWidth: 120, title: '创建时间'},
            //{field: 'updated_at', minWidth: 120, title: '更新时间'},
            {
                width: 250,
                title: '操作',
                operate: [
                    'edit',
                    function (data) {
                        return $('#copy-tpl').html().replaceAll("ident202306", data['ident']);
                    },
                    'delete',
                    function (data) {
                        return $('#more-tpl').html().replaceAll('id202306', data['id']);
                    },
                ]
            }
        ]);

    </script>
@endsection
