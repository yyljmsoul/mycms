<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>管理后台 - {{system_config('site_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="/mycms/admin/images/logo-sm.png">

    <!-- AdminLTE CSS -->
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
<!-- jQuery -->
<script src="/static/plugins/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- layui -->
<script src="/static/plugins/layui/layui.js"></script>
<!-- webuploader -->
<link rel="stylesheet" href="/static/plugins/webuploader-0.1.5/webuploader.css">
<script src="/static/plugins/webuploader-0.1.5/webuploader.min.js"></script>
<!-- ckeditor4 -->
<script src="/static/plugins/ckeditor/ckeditor.js"></script>
<!-- Bootstrap Table -->
<link rel="stylesheet" href="/static/plugins/bootstrap-table/bootstrap-table.min.css" />
<!-- layer 弹层组件 -->
<script>
    layui.use('layer',
        function () {
            var layer = layui.layer;
        })
</script>
<!-- zTree 树节点组件 -->
<script type="text/javascript" src="/static/plugins/zTree_v3/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/static/plugins/zTree_v3/js/jquery.ztree.excheck.js"></script>
<!-- jQueryTagsInput -->
<link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/jQueryTagsInput/jquery.tagsinput.css">
<script src="/static/plugins/AdminLTE/plugins/jQueryTagsInput/jquery.tagsinput.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<script src="/static/plugins/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
<!-- CodeMirror -->
<link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="/static/plugins/AdminLTE/plugins/codemirror/theme/monokai.css">

<!-- SIYUCMS -->
<link rel="stylesheet" href="/static/plugins/AdminLTE/dist/css/siyucms.css?v=20211203">
<script src="/static/plugins/siyu-ui.js?v=20211203"></script>
<script src="/static/plugins/siyucms.js?v=20211203"></script>

    <style>
        .text-end-cms {
            text-align: right;
        }

        @media all and (max-width: 768px) {
            .text-end-cms {
                text-align: left;
            }
        }
    </style>

    <script>
        const SYSTEM_PREFIX = '{{system_config('admin_prefix') ?: 'admin'}}';
    </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('system.index')}}" class="nav-link">首页</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Full screen button -->
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <!-- User dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <span class="d-none d-xl-inline-block ms-1">{{$auth_admin_user->name}}</span>
                    <i class="fas fa-angle-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="/" target="_blank" class="dropdown-item">
                        <i class="fas fa-home mr-2"></i> 网站首页
                    </a>
                    <a href="javascript:" id="update-cache" class="dropdown-item">
                        <i class="fas fa-sync-alt mr-2"></i> 清理缓存
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:" id="login-out" class="dropdown-item text-danger">
                        <i class="fas fa-power-off mr-2"></i> 安全退出
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{route('system.index')}}" class="brand-link">
            <img src="/mycms/admin/images/logo-sm.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{system_config('site_name')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <!-- 可根据实际情况添加用户头像 -->
                    <img src="/mycms/admin/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{$auth_admin_user->name}}</a>
                    <span class="text-muted">{{$auth_admin_user->role->role_name}}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-header">Dashboard</li>
                    <li class="nav-item">
                        <a href="/admin" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>控制台首页</p>
                        </a>
                    </li>
                    <li class="nav-header">System Menu</li>
                    @foreach($system_menus[0] as $menu)
                        @if(isset($system_menus[$menu['id']]))
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon {{$menu['icon']}}"></i>
                                    <p>
                                        {{$menu['title']}}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @foreach($system_menus[$menu['id']] as $child)
                                        <li class="nav-item">
                                            <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", $child['url'])}}"
                                               class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>{{$child['title']}}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", $menu['url'])}}"
                                   class="nav-link">
                                    <i class="nav-icon {{$menu['icon']}}"></i>
                                    <p>{{$menu['title']}}</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li class="nav-header">Tools</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                支付示例
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{myRoute('system.demo.pay.alipay')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>支付宝</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{myRoute('system.demo.pay.wechat')}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>微信支付</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                图标大全
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{myRoute('system.icons', ['ident' => 'materialdesign'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Material Design</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{myRoute('system.icons', ['ident' => 'dripicons'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dripicons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{myRoute('system.icons', ['ident' => 'fontawesome'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Font awesome</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{myRoute('system.icons', ['ident' => 'themify'])}}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Themify Icons</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$current_page_name}}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin">{{system_config('site_name')}}</a></li>
                            @if($prev_page_name)
                                <li class="breadcrumb-item"><a
                                        href="{{$prev_page_url ?: ''}}">{{$prev_page_name}}</a></li>
                            @endif
                            <li class="breadcrumb-item active">{{$current_page_name}}</li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        @if($prev_page_url)
                            <div class="float-right">
                                <a href="{{$prev_page_url}}" class="btn btn-success">返回列表</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('container-fluid')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            <!-- 可根据需要添加右侧内容 -->
        </div>
        <strong>© {{date('Y')}} 东莞市一码网络科技有限公司版权所有.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>设置风格</h5>
            <div class="mb-2">
                <img src="/mycms/admin/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                <label class="form-check-label" for="light-mode-switch">明亮模式</label>
            </div>
            <div class="mb-2">
                <img src="/mycms/admin/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                       data-bsStyle="/mycms/admin/css/bootstrap-dark.min.css"
                       data-appStyle="/mycms/admin/css/app-dark.min.css">
                <label class="form-check-label" for="dark-mode-switch">暗黑模式</label>
            </div>
        </div>
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
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

<script>
    $('#update-cache').click(function () {
        myAdmin.request.get('/admin/update-cache', {}, function () {
            myAdmin.message.success('更新成功');
        });
    });
    $('#login-out').click(function () {
        myAdmin.request.get('/admin/logout', {}, function () {
            myAdmin.message.success('退出成功', function () {
                window.location = '/admin/login';
            });
        });
    });
</script>

<div id="extend-javascript">
    @yield('extend-javascript')
</div>
</body>

</html>
