<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理 - MyCms</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{system_resource_url("/mycms/admin/css/public.css")}}" media="all">
    <link rel="stylesheet" href="{{system_resource_url("/mycms/plugs/neditor-2.1/third-party/xiumi/xiumi-ue-v5.css")}}"
          media="all">
    <script>
        window.CONFIG = {
            ADMIN: "mycms",
            CONTROLLER_JS_PATH: "@if(isset($diy_js_path)){{$diy_js_path}}@else{{$js_path}}@endif",
            ACTION: "@if(isset($diy_action)){{$diy_action}}@else{{$js_action}}@endif",
            IS_SUPER_ADMIN: "1",
            VERSION: "{{$version}}",
            MENU_MULTI: {{system_config('menu_show_type') ?: 0}},
            MENU_OPEN: {{system_config('menu_default_open') ?: 0}},
            IS_WE7: {!! $IS_WE7 ?: "''" !!},
            WE7_ADDON_NAME: "{{$WE7_ADDON_NAME}}",
            EDITOR: "{{$editor}}",
        };

    </script>

    @if($editor == 'ue')
        <!-- 配置文件 -->
        <script type="text/javascript"
                src="{{system_resource_url("/mycms/plugs/neditor-2.1/neditor.config.js")}}?v={{config('app.version')}}"></script>
        <!-- 配置文件 -->
        <script type="text/javascript"
                src="{{system_resource_url("/mycms/plugs/neditor-2.1/third-party/zeroclipboard/ZeroClipboard.js")}}?v={{config('app.version')}}"></script>
        <!-- 编辑器源码文件 -->
        <script type="text/javascript"
                src="{{system_resource_url("/mycms/plugs/neditor-2.1/neditor.all.js")}}?v={{config('app.version')}}"></script>
        <script type="text/javascript"
                src="{{system_resource_url("/mycms/plugs/neditor-2.1/neditor.service.js")}}?v={{config('app.version')}}"></script>
        <script type="text/javascript"
                src="{{system_resource_url("/mycms/plugs/neditor-2.1/third-party/xiumi/xiumi-ue-dialog-v5.js")}}?v={{config('app.version')}}"></script>
    @endif
    <script src="{{system_resource_url("/mycms/plugs/layui-v2.5.6/layui.all.js")}}?v={{config('app.version')}}"
            charset="utf-8"></script>
    <script src="{{system_resource_url("/mycms/plugs/require-2.3.6/require.js")}}?v={{config('app.version')}}"
            charset="utf-8"></script>
    <script src="{{system_resource_url("/mycms/config-admin.js")}}?v={{config('app.version')}}"
            charset="utf-8"></script>

</head>
