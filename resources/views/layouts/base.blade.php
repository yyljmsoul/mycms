<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理后台 - {{system_config('site_name')}}</title>

    <!-- layui -->
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/google-fonts/google.fonts.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/toastr/toastr.min.css">
    <!-- pace-progress -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
    <!-- webuploader -->
    <link rel="stylesheet" href="/static/plugins/webuploader-0.1.5/webuploader.css">
    <!-- Bootstrap Table -->
    <link rel="stylesheet" href="/static/plugins/bootstrap-table/bootstrap-table.min.css" />
    <link rel="stylesheet" href="/static/plugins/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css"/>
    <!-- jQueryTagsInput -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/jQueryTagsInput/jquery.tagsinput.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/codemirror/codemirror.css">
    <link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/codemirror/theme/monokai.css">
    <!-- jquery-treegrid -->
    <link rel="stylesheet" href="/static/plugins/jquery-treegrid/css/jquery.treegrid.css">
    <!-- jQuery -->
<script src="/static/plugins/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- layui -->
<script src="/static/plugins/layui/layui.js"></script>
<!-- webuploader -->
<link rel="stylesheet" href="/static/plugins/webuploader-0.1.5/webuploader.css">
<script src="/static/plugins/webuploader-0.1.5/webuploader.min.js"></script>
    <!-- SIYUCMS -->
    <link rel="stylesheet" href="/static/plugins/AdminLTE/dist/css/siyucms.css?v=20211203">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        const SYSTEM_PREFIX = '{{system_config('admin_prefix') ?: 'admin'}}';
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed pace-primary text-sm " data-display_mode="1">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Left navbar links -->
        <ul class="navbar-nav js_left_menu">
            <li class="nav-item active">
                <a class="nav-link" href="javascript:;">
                    <i class="fas fa-cog"></i>
                    <span>主导航</span>
                </a>
            </li>
            <!-- 这里可以根据实际情况动态生成导航 -->
            @foreach($system_menus[0] as $menu)
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;">
                        <i class="{{$menu['icon']}}"></i>
                        <span>{{$menu['title']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Account Menu -->
            <li class="nav-item dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="/static/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="user-image">
                    <span class="d-none d-lg-block">{{$auth_admin_user->name}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="user-header">
                        <img src="/static/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle">
                        <h5>上次登录时间：{{$auth_admin_user->last_login_time ?? '暂无记录'}}</h5>
                        <h5>上次登录IP：{{$auth_admin_user->last_login_ip ?? '暂无记录'}}</h5>
                    </li>
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin/Admin/edit')}}" class="nav-link btn btn-default btn-flat" style="padding: 0.375rem 0.75rem;height: auto;">资料</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin/Login/logout')}}" class="btn btn-default btn-flat">退出</a>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="全屏">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="自定义">
                    <i class="fas fa-palette"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link js_clear_cash" href="javascript:;" title="清空缓存">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/" target="_blank" title="前台首页">
                    <i class="fas fa-home"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-default elevation-4">
        <!-- Brand Logo -->
        <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin/Index/index')}}" class="brand-link">
            <img src="/static/plugins/AdminLTE/dist/img/AdminLTELogo.png" alt="MyCms" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">MyCms</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/static/plugins/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2">
                </div>
                <div class="info">
                    <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin/Admin/edit')}}" class="d-block">{{$auth_admin_user->name}}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2 mb-2">
                <ul class="nav nav-pills no_radius nav-sidebar flex-column nav-child-indent js_left_menu_show" data-widget="treeview" role="menu" data-accordion="true">
                    <li data-item="0" class="nav-header nav-item_0">主导航</li>
                    @foreach($system_menus[0] as $menu)
                        <li data-item="0" class="nav-item nav-item_0 has-treeview">
                            <a href="#" class="nav-link">
                                <i class="{{$menu['icon']}} nav-icon"></i>
                                <p>
                                    {{$menu['title']}}
                                    @if(isset($system_menus[$menu['id']]))
                                        <i class="right fas fa-angle-left"></i>
                                    @endif
                                </p>
                            </a>
                            @if(isset($system_menus[$menu['id']]))
                                <ul class="nav nav-treeview">
                                    @foreach($system_menus[$menu['id']] as $child)
                                        <li class="nav-item ">
                                            <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", $child['url'])}}" class="nav-link">
                                                <i class="{{$child['icon']}} nav-icon"></i>
                                                <p>{{$child['title']}}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <script>
        // 主导航、内容管理切换
        $(".js_left_menu li").click(function () {
            // 通过 .index()方法获取元素下标（从0开始）
            var _index = $(this).index();
            // 让左侧菜单第 _index 个显示出来，其他的隐藏起来
            $(".js_left_menu_show > li").hide();
            $(".js_left_menu_show > li.nav-item_" + _index).show();
            // 当前菜单添加选中效果，同级的移除选中效果
            $(this).addClass('active').siblings('li').removeClass('active');
        });

        // 清空缓存
        $(".js_clear_cash").click(function () {
            var url = "{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin/index/clear')}}";
            $.modal.confirm('确定要清除缓存吗？', function () {
                $.post(url, {
                    del: true
                }, function (result) {
                    if (result.error == 0) {
                        $.modal.alertSuccess(result.msg, function (index) {
                            layer.close(index);
                            $.pjax.reload('.content-wrapper'); // pjax 重载
                        });
                    } else {
                        $.modal.alertError(result.msg);
                    }
                });
            });
        });
    </script>

    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="600">
        <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0">
            <div class="nav-item dropdown">
                <a class="nav-link bg-danger dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Close</a>
                <div class="dropdown-menu mt-0">
                    <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all">Close All</a>
                    <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all-other">Close All Other</a>
                </div>
            </div>
            <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
            <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
            <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
            <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
        </div>
        <div class="tab-content">
            <div class="tab-empty">
                
            </div>
            <!--<div class="tab-loading">
                <div>
                    <h2 class="display-4">loading <i class="fa fa-sync fa-spin"></i></h2>
                </div>
            </div>-->
        </div>

        <!-- 页面内容 -->
        <div class="page-content">
            <!-- start page title -->
            <div class="page-title-box">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-sm-6">
                            <div class="page-title">
                                <h4>{{$current_page_name}}</h4>
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", '/admin')}}">{{system_config('site_name')}}</a></li>
                                    @if($prev_page_name)
                                        <li class="breadcrumb-item"><a
                                                href="{{$prev_page_url ?: ''}}">{{$prev_page_name}}</a></li>
                                    @endif
                                    <li class="breadcrumb-item active">{{$current_page_name}}</li>
                                </ol>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            @if($prev_page_url)
                                <div class="float-end d-none d-sm-block">
                                    <a href="{{$prev_page_url}}" class="btn btn-success">返回列表</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            @yield('container-fluid')
        </div>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright &copy; {{date('Y')}} 东莞市一码网络科技有限公司版权所有.</strong>
        <div class="float-right d-none d-sm-inline-block">
            <!-- 这里可以添加版本信息 -->
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Bootstrap 4 -->
<script src="/static/plugins/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- daterangepicker -->
<script src="/static/plugins/AdminLTE/plugins/moment/moment.min.js"></script>
<script src="/static/plugins/AdminLTE/plugins/moment/locale/zh-cn.js"></script>
<script src="/static/plugins/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/static/plugins/AdminLTE/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/static/plugins/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/static/plugins/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Toastr -->
<script src="/static/plugins/AdminLTE/plugins/toastr/toastr.min.js"></script>
<!-- pace-progress -->
<script src="/static/plugins/AdminLTE/plugins/pace-progress/pace.min.js"></script>
<!-- Bootstrap Table 表格插件样式 -->
<script src="/static/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script src="/static/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js"></script>
<script src="/static/plugins/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js"></script>
<script src="/static/plugins/bootstrap-table/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>
<link rel="stylesheet" href="/static/plugins/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.css"/>
<script src="/static/plugins/bootstrap-table/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
<!-- AdminLTE App -->
<script src="/static/plugins/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/static/plugins/AdminLTE/dist/js/demo.js"></script>
<!-- pjax -->
<script src="/static/plugins/AdminLTE/plugins/pjax/jquery.pjax.js"></script>
<!-- jQueryForm -->
<script src="/static/plugins/AdminLTE/plugins/jQueryForm/jquery.form.js"></script>
<!-- CodeMirror -->
<script src="/static/plugins/AdminLTE/plugins/codemirror/codemirror.js"></script>
<script src="/static/plugins/AdminLTE/plugins/codemirror/mode/css/css.js"></script>
<script src="/static/plugins/AdminLTE/plugins/codemirror/mode/xml/xml.js"></script>
<script src="/static/plugins/AdminLTE/plugins/codemirror/mode/javascript/javascript.js"></script>
<script src="/static/plugins/AdminLTE/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<!-- jquery-treegrid -->
<link rel="stylesheet" href="/static/plugins/jquery-treegrid/css/jquery.treegrid.css">
<script src="/static/plugins/jquery-treegrid/js/jquery.treegrid.js"></script>
<script src="/static/plugins/bootstrap-table/extensions/treegrid/bootstrap-table-treegrid.js"></script>


<div id="extend-javascript">
    @yield('extend-javascript')
</div>
</body>

</html>
