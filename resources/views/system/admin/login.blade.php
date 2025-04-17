<!doctype html>
<html lang="zh-cn">
<head>

    <meta charset="utf-8"/>
    <title>管理后台 - {{system_config('site_name')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="/mycms/admin/images/favicon.ico">

    <!-- Sweet Alert-->
    <link href="/mycms/admin/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

    <!-- Bootstrap Css -->
    <link href="/mycms/admin/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="/mycms/admin/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="/mycms/admin/css/app.min.css" id="app-style" rel="stylesheet" type="text/css"/>

    <script>
        const SYSTEM_PREFIX = '{{system_config('admin_prefix') ?: 'admin'}}';
    </script>
</head>


<body class="authentication-bg bg-primary">
<div class="home-center" data-previous-aria-hidden="false">
    <div class="home-desc-center">

        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="px-2 py-3">


                                <div class="text-center">
                                    <a href="https://www.mycms.net.cn" target="_blank">
                                        <img src="/mycms/admin/images/logo-dark.png" height="22" alt="logo">
                                    </a>

                                    <h5 class="text-primary mb-2 mt-4">欢迎回来！请登录后使用.</h5>
                                </div>


                                <form id="form-submit">

                                    <div class="mb-3">
                                        <label for="name">账号</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="请输入账号" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password">密码</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="请输入密码" required data-parsley-minlength="5">
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light"
                                                type="submit">马上登录
                                        </button>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center text-white">
                        <p>© {{date('Y')}} 东莞市一码网络科技有限公司版权所有.
                        </p>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <!-- End Log In page -->
</div>


<!-- JAVASCRIPT -->
<script src="/mycms/admin/libs/jquery/jquery.min.js"></script>
<script src="/mycms/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/mycms/admin/libs/metismenu/metisMenu.min.js"></script>
<script src="/mycms/admin/libs/simplebar/simplebar.min.js"></script>
<script src="/mycms/admin/libs/node-waves/waves.min.js"></script>
<script src="/mycms/admin/libs/parsleyjs/parsley.min.js"></script>
<script src="/mycms/admin/libs/parsleyjs/i18n/zh_cn.js"></script>
<script src="/mycms/admin/js/pages/form-validation.init.js"></script>
<!-- Sweet Alerts js -->
<script src="/mycms/admin/libs/sweetalert2/sweetalert2.min.js"></script>

<script src="/mycms/admin/js/app.js"></script>
<script src="/mycms/admin/js/admin.js"></script>

<script>
    myAdmin.form("#form-submit", function () {
        setTimeout(function () {
            location.href = "{!! myRoute('system.index') !!}";
        }, 300);
    })
</script>

</body>

</html>
