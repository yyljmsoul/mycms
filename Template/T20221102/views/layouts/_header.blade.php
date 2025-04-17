<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link media="all" href="/mycms/cms/theme/T20221102/static/css/7d0a78e0abc2152cf33c9a6474009f9e.css" rel="stylesheet"/>
    <title>{{page_title()}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telphone=no, email=no">
    <meta name="applicable-device" content="mobile,pc">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="shortcut icon" type="images/png" href="/favicon.png">
    <link rel="apple-touch-icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon-precomposed" type="image/png" href="/favicon.png">
    <meta name="keywords" content="{{page_keyword()}}"/>
    <meta name="description" content="{{page_description()}}"/>
    <script async="" src="/mycms/cms/theme/T20221102/static/js/85922944736a40a799ed700caa5cbb94.js"></script>
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="renderer" content="webkit">
    <meta name="referrer" content="always">

</head>
<body>
<div class="k-header">
    <nav class="k-nav navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            @if (is_home())
                <h1 style="margin: 0px 0 10px;"><a class="navbar-brand"
                                                   href="{{system_config('site_url')}}"> {{system_config('site_name')}} </a>
                </h1>
            @else
                <a class="navbar-brand"
                   href="{{system_config('site_url')}}"> {{system_config('site_name')}} </a>
            @endif
            <button class="navbar-toggler navbar-toggler-right" id="navbutton" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="line first-line"></span> <span
                    class="line second-line"></span> <span class="line third-line"></span></button>
            <div id="navbarResponsive" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    @foreach(navs() as $key => $nav)
                        <li class="nav-item"><a title="{{$nav->name}}" href="{{$nav->url}}"
                                                class="nav-link">{{$nav->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
    <div class="banner">
        <div class="overlay"></div>
        <div class="lazyload content text-center"
             style="background-image: url(/mycms/cms/theme/T20221102/static/images/background.png);"></div>
    </div>
</div>
