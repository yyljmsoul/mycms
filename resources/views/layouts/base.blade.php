<!doctype html>
<html lang="en">

<head>


    <meta charset="utf-8"/>
    <title>管理后台 - {{system_config('site_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="/mycms/admin/images/logo-sm.png">

    <!-- plugin css -->
    <link href="/mycms/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
          type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="/mycms/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="/mycms/admin/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="/mycms/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>

    <!-- Sweet Alert-->
    <link href="/mycms/admin/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <!-- DataTables -->
    <link href="/mycms/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="/mycms/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet"
          type="text/css"/>

    <!-- Responsive Table css -->
    <link href="/mycms/admin/libs/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css"/>

    <link href="/mycms/admin/css/nprogress.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://static.zaixianjisuan.com/public/css/bootstrap-datetimepicker.min.css">

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


<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">

                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{route('system.index')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="/mycms/admin/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/mycms/admin/images/logo-dark.png" alt="" height="20">
                        </span>
                    </a>

                    <a href="{{route('system.index')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="/mycms/admin/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="/mycms/admin/images/logo-light.png" alt="" height="20">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

            </div>

            <div class="d-flex">

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-none d-xl-inline-block ms-1">{{$auth_admin_user->name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="/" target="_blank"><i
                                class="dripicons-home font-size-16 align-middle me-1"></i> 网站首页</a>
                        <a class="dropdown-item d-block" id="update-cache" href="javascript:"><i
                                class="dripicons-gear font-size-16 align-middle me-1"></i> 清理缓存</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" id="login-out" href="javascript:"><i
                                class="dripicons-power font-size-16 align-middle me-1 text-danger"></i> 安全退出</a>
                    </div>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="mdi mdi-cog-outline font-size-20"></i>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">


            <div class="user-sidebar text-center">
                <div class="dropdown">
                    <div class="user-info">
                        <h5 class="mt-3 font-size-16 text-white">{{$auth_admin_user->name}}</h5>
                        <span class="font-size-13 text-white-50">{{$auth_admin_user->role->role_name}}</span>
                    </div>
                </div>
            </div>


            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Dashboard</li>
                    <li>
                        <a href="/admin" class="waves-effect">
                            <i class="dripicons-home"></i>
                            <span>控制台首页</span>
                        </a>
                    </li>
                    <li class="menu-title">System Menu</li>
                    @foreach($system_menus[0] as $menu)
                        <li>
                            @if(system_admin_role_id() == 1)
                                <a href="javascript: void(0);"
                                   @if(isset($system_menus[$menu['id']])) class="has-arrow waves-effect" @endif>
                                    <i class="{{$menu['icon']}}"></i>
                                    <span>{{$menu['title']}}</span>
                                </a>
                            @else
                                @if(isset($system_menus[$menu['id']]))
                                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                                        <i class="{{$menu['icon']}}"></i>
                                        <span>{{$menu['title']}}</span>
                                    </a>
                                @endif
                            @endif

                            @if(isset($system_menus[$menu['id']]))
                                <ul class="sub-menu" aria-expanded="false">
                                    @foreach($system_menus[$menu['id']] as $child)
                                        <li>
                                            <a href="{{str_replace("/admin/", "/" . (system_config('admin_prefix') ?: 'admin') . "/", $child['url'])}}"><span>{{$child['title']}}</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    <li class="menu-title">Tools</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="dripicons-wallet"></i>
                            <span>支付示例</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{myRoute('system.demo.pay.alipay')}}">支付宝</a></li>
                            <li><a href="{{myRoute('system.demo.pay.wechat')}}">微信支付</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="dripicons-basket"></i>
                            <span>图标大全</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{myRoute('system.icons', ['ident' => 'materialdesign'])}}">Material Design</a>
                            </li>
                            <li><a href="{{myRoute('system.icons', ['ident' => 'dripicons'])}}">Dripicons</a></li>
                            <li><a href="{{myRoute('system.icons', ['ident' => 'fontawesome'])}}">Font awesome</a></li>
                            <li><a href="{{myRoute('system.icons', ['ident' => 'themify'])}}">Themify Icons</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div id="main-content" class="main-content">

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
                                            href="/admin">{{system_config('site_name')}}</a></li>
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
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        © {{date('Y')}} 东莞市一码网络科技有限公司版权所有.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">

            <h5 class="m-0 me-2">设置风格</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0"/>
        <h6 class="text-center mb-0">选择后台风格</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="/mycms/admin/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox"
                       id="light-mode-switch" checked>
                <label class="form-check-label" for="light-mode-switch">明亮模式</label>
            </div>

            <div class="mb-2">
                <img src="/mycms/admin/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox"
                       id="dark-mode-switch"
                       data-bsStyle="/mycms/admin/css/bootstrap-dark.min.css"
                       data-appStyle="/mycms/admin/css/app-dark.min.css">
                <label class="form-check-label" for="dark-mode-switch">暗黑模式</label>
            </div>


        </div>

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<script>
    let defaultEditor = '{{$system_editor}}';
</script>

<!-- JAVASCRIPT -->
<script src="/mycms/admin/libs/jquery/jquery.min.js"></script>
<script src="/mycms/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/mycms/admin/libs/metismenu/metisMenu.min.js"></script>
<script src="/mycms/admin/libs/simplebar/simplebar.min.js"></script>
<script src="/mycms/admin/libs/node-waves/waves.min.js"></script>

<!-- apexcharts -->
<script src="/mycms/admin/libs/apexcharts/apexcharts.min.js"></script>

<script src="/mycms/admin/libs/parsleyjs/parsley.min.js"></script>
<script src="/mycms/admin/libs/parsleyjs/i18n/zh_cn.js"></script>

<!-- Sweet Alerts js -->
<script src="/mycms/admin/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- Responsive Table js -->
<script src="/mycms/admin/libs/admin-resources/rwd-table/rwd-table.min.js"></script>

<script src="/mycms/admin/libs/moment/min/moment.min.js"></script>

<!-- Editor js -->
@if($system_editor == '' || $system_editor == 'ck')
    <script src="/mycms/admin/libs/ckeditor/ckeditor.js"></script>
@elseif ($system_editor == 'md')
    <link rel="stylesheet" href="/mycms/admin/editormd/css/editormd.css"/>
    <script src="/mycms/admin/editormd/editormd.min.js"></script>
@else

    <link rel="stylesheet" href="/mycms/admin/libs/neditor/third-party/xiumi/xiumi-ue-v5.css"
          media="all">

    <script type="text/javascript"
            src="/mycms/admin/libs/neditor/neditor.config.js"></script>
    <script type="text/javascript"
            src="/mycms/admin/libs/neditor/third-party/zeroclipboard/ZeroClipboard.js"></script>
    <script type="text/javascript"
            src="/mycms/admin/libs/neditor/neditor.all.js"></script>
    <script type="text/javascript"
            src="/mycms/admin/libs/neditor/neditor.service.js"></script>
    <script type="text/javascript"
            src="/mycms/admin/libs/neditor/third-party/xiumi/xiumi-ue-dialog-v5.js"></script>

@endif

@if(auth()->guard('admin')->user())
    <script>var system_admin_role_id = {{system_admin_role_id()}};</script>
    <script>var admin_role_nodes = {!! json_encode($admin_role_nodes) !!};</script>
@endif



<!-- Required datatable js -->
<script src="/mycms/admin/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/mycms/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="/mycms/admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/mycms/admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="/mycms/admin/libs/jszip/jszip.min.js"></script>
<script src="/mycms/admin/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="/mycms/admin/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="/mycms/admin/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/mycms/admin/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/mycms/admin/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Plugins js -->
<script src="/mycms/admin/libs/dropzone/min/dropzone.min.js"></script>
<script src="/mycms/admin/js/jquery-ui.js"></script>

<!-- Plugins js-->
<script src="/mycms/admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/mycms/admin/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="/mycms/admin/js/app.js"></script>
<script src="/mycms/admin/js/admin.js"></script>
<script src="/mycms/admin/js/jquery.pjax.js"></script>
<script src="/mycms/admin/js/nprogress.js"></script>

<script src="https://static.zaixianjisuan.com/public/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://static.zaixianjisuan.com/public/js/bootstrap-datetimepicker.zh-CN.js"></script>

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

    $(document).on('click', '#sidebar-menu a,.btn-toolbar a,#currentTable a,.page-title-box a', function (event) {
        $.pjax.click(event, {container: '#main-content'});
        $('#sidebar-menu a').removeClass('active');
    });

    $(document).on('pjax:start', function () {
        NProgress.start();
    });
    $(document).on('pjax:end', function () {
        NProgress.done();
    });
    $(document).on('pjax:beforeSend', function (event) {
        const url = event.currentTarget.URL;
        myAdmin.history.push(url);
    })
    $(window).on('popstate', function () {
        $.pjax({url: myAdmin.history[myAdmin.history.length - 1], container: '#main-content'})
    });
</script>

<div id="extend-javascript">
    @yield('extend-javascript')
</div>


</body>

</html>
