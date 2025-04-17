@extends("layouts.common")
<style>
    body {
        margin: 15px 15px 15px 15px;
        background: #f2f2f2;
    }

    .layui-card {
        border: 1px solid #f2f2f2;
        border-radius: 5px;
    }

    .icon {
        margin-right: 10px;
        color: #1aa094;
    }

    .icon-cray {
        color: #ffb800 !important;
    }

    .icon-blue {
        color: #1e9fff !important;
    }

    .icon-tip {
        color: #ff5722 !important;
    }

    .layuimini-qiuck-module {
        text-align: center;
        margin-top: 10px
    }

    .layuimini-qiuck-module a i {
        display: inline-block;
        width: 100%;
        height: 60px;
        line-height: 60px;
        text-align: center;
        border-radius: 2px;
        font-size: 30px;
        background-color: #F8F8F8;
        color: #333;
        transition: all .3s;
        -webkit-transition: all .3s;
    }

    .layuimini-qiuck-module a cite {
        position: relative;
        top: 2px;
        display: block;
        color: #666;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
        font-size: 14px;
    }

    .welcome-module {
        width: 100%;
        height: 210px;
    }

    .panel {
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 3px;
        -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: 0 1px 1px rgba(0, 0, 0, .05)
    }

    .panel-body {
        padding: 10px
    }

    .panel-title {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 12px;
        color: inherit
    }

    .label {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
        margin-top: .3em;
    }

    .layui-red {
        color: red
    }

    .main_btn > p {
        height: 40px;
    }

    .layui-bg-number {
        background-color: #F8F8F8;
    }

    .layuimini-notice:hover {
        background: #f6f6f6;
    }

    .layuimini-notice {
        padding: 7px 16px;
        clear: both;
        font-size: 12px !important;
        cursor: pointer;
        position: relative;
        transition: background 0.2s ease-in-out;
    }

    .layuimini-notice-title, .layuimini-notice-label {
        padding-right: 70px !important;
        text-overflow: ellipsis !important;
        overflow: hidden !important;
        white-space: nowrap !important;
    }

    .layuimini-notice-title {
        line-height: 28px;
        font-size: 14px;
    }

    .layuimini-notice-extra {
        position: absolute;
        top: 50%;
        margin-top: -8px;
        right: 16px;
        display: inline-block;
        height: 16px;
        color: #999;
    }
</style>
@section('page-content-wrapper')

    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-database icon icon-blue"></i>数据统计</div>
                        <div class="layui-card-body">
                            <div class="welcome-module">
                                <div class="layui-row layui-col-space10">
                                    <div class="layui-col-xs6">
                                        <div class="panel layui-bg-number">
                                            <div class="panel-body">
                                                <div class="panel-title">
                                                    <span class="label pull-right layui-bg-blue">实时</span>
                                                    <h5>文章统计</h5>
                                                </div>
                                                <div class="panel-content">
                                                    <h1 class="no-margins">{{$article_count}}</h1>
                                                    <small>当前文章总记录数</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-col-xs6">
                                        <div class="panel layui-bg-number">
                                            <div class="panel-body">
                                                <div class="panel-title">
                                                    <span class="label pull-right layui-bg-cyan">实时</span>
                                                    <h5>用户统计</h5>
                                                </div>
                                                <div class="panel-content">
                                                    <h1 class="no-margins">{{$user_count}}</h1>
                                                    <small>当前用户总记录数</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-col-xs6">
                                        <div class="panel layui-bg-number">
                                            <div class="panel-body">
                                                <div class="panel-title">
                                                    <span class="label pull-right layui-bg-orange">实时</span>
                                                    <h5>浏览统计</h5>
                                                </div>
                                                <div class="panel-content">
                                                    <h1 class="no-margins">{{$view_count}}</h1>
                                                    <small>当前文章浏览总数</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="layui-col-xs6">
                                        <div class="panel layui-bg-number">
                                            <div class="panel-body">
                                                <div class="panel-title">
                                                    <span class="label pull-right layui-bg-green">实时</span>
                                                    <h5>商品统计</h5>
                                                </div>
                                                <div class="panel-content">
                                                    <h1 class="no-margins">{{$goods_count}}</h1>
                                                    <small>当前商品总记录数</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-credit-card icon icon-blue"></i>快捷入口</div>
                        <div class="layui-card-body">
                            <div class="welcome-module">
                                <div class="layui-row layui-col-space10 layuimini-qiuck">
                                    <div class="layui-col-xs3 layuimini-qiuck-module">
                                        <a href="javascript:;" layuimini-content-href="/admin/addon" data-title="插件管理"
                                           data-icon="fa fa-plus-square">
                                            <i class="fa fa-plus-square"></i>
                                            <cite>插件管理</cite>
                                        </a>
                                    </div>
                                    <div class="layui-col-xs3 layuimini-qiuck-module">
                                        <a href="javascript:;" layuimini-content-href="/admin/config" data-title="系统设置"
                                           data-icon="fa fa-gears">
                                            <i class="fa fa-gears"></i>
                                            <cite>系统设置</cite>
                                        </a>
                                    </div>
                                    <div class="layui-col-xs3 layuimini-qiuck-module">
                                        <a href="javascript:;" layuimini-content-href="/article/admin" data-title="文章管理"
                                           data-icon="fa fa-file-text">
                                            <i class="fa fa-file-text"></i>
                                            <cite>文章管理</cite>
                                        </a>
                                    </div>
                                    <div class="layui-col-xs3 layuimini-qiuck-module">
                                        <a href="javascript:;" layuimini-content-href="/user/admin/" data-title="用户管理"
                                           data-icon="fa fa-users">
                                            <i class="fa fa-users"></i>
                                            <cite>用户管理</cite>
                                        </a>
                                    </div>
                                    <div class="layui-col-xs3 layuimini-qiuck-module">
                                        <a href="javascript:;" layuimini-content-href="/admin/shop/goods"
                                           data-title="商品列表" data-icon="fa fa-shopping-bag">
                                            <i class="fa fa-shopping-bag"></i>
                                            <cite>商品列表</cite>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="layui-col-md4">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-fire icon"></i>版本信息</div>
                        <div class="layui-card-body layui-text">
                            <table class="layui-table">
                                <colgroup>
                                    <col width="100">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <td>系统名称</td>
                                    <td>
                                        MyCms
                                    </td>
                                </tr>
                                <tr>
                                    <td>当前版本</td>
                                    <td>{{config('app.version')}}</td>
                                </tr>
                                <tr>
                                    <td>主要特色</td>
                                    <td>模块化 / 响应式 / 易拓展</td>
                                </tr>
                                <tr>
                                    <td>下载地址</td>
                                    <td>
                                        <a href="https://www.mycms.net.cn" target="_blank">官网下载</a> / <a
                                            href="https://gitee.com/qq386654667/mycms" target="_blank">gitee</a> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gitee</td>
                                    <td style="padding-bottom: 0;">
                                        <div class="layui-btn-container">
                                            <a href="https://gitee.com/qq386654667/mycms" target="_blank"
                                               style="margin-right: 15px"><img
                                                    src="https://gitee.com/qq386654667/mycms/badge/star.svg?theme=dark"
                                                    alt="star"></a>
                                            <a href="https://gitee.com/qq386654667/mycms" target="_blank"><img
                                                    src="https://gitee.com/qq386654667/mycms/badge/fork.svg?theme=dark"
                                                    alt="fork"></a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md12">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-paste icon icon-blue"></i>文章TOP</div>
                        <div class="layui-card-body">
                            <table class="layui-table">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <tr>
                                    <th><b>排名</b></th>
                                    <th><b>ID</b></th>
                                    <th><b>标题</b></th>
                                    <th><b>浏览</b></th>
                                </tr>
                                <tbody>
                                @foreach($articles = articles(1,7,'hot') as $key => $article)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$article->id}}</td>
                                        <td>{{$article->title}}</td>
                                        <td>{{$article->view}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header"><i class="fa fa-users icon icon-blue"></i>最新会员</div>
                        <div class="layui-card-body">
                            <table class="layui-table">
                                <colgroup>
                                    <col>
                                    <col>
                                    <col>
                                    <col>
                                </colgroup>
                                <tr>
                                    <th><b>ID</b></th>
                                    <th><b>账号</b></th>
                                    <th><b>手机</b></th>
                                    <th><b>日期</b></th>
                                </tr>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->mobile}}</td>
                                        <td>{{$user->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
