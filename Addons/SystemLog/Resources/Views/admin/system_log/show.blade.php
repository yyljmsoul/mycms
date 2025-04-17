@extends("layouts.common")
@section('page-content-wrapper')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <td>管理员ID</td>
            <td>{{$systemLog->admin_id}}</td>
        </tr>
        <tr>
            <td>管理员名称</td>
            <td>{{$systemLog->admin_name}}</td>
        </tr>
        <tr>
            <td>ip地址</td>
            <td>{{$systemLog->ip}}</td>
        </tr>
        <tr>
            <td>请求方式</td>
            <td>{{$systemLog->method}}</td>
        </tr>
        <tr>
            <td>请求URL</td>
            <td>{{$systemLog->url}}</td>
        </tr>
        <tr>
            <td>请求参数</td>
            <td>{{$systemLog->param}}</td>
        </tr>
        <tr>
            <td>userAgent</td>
            <td>{{$systemLog->useragent}}</td>
        </tr>
        <tr>
            <td>时间</td>
            <td>{{$systemLog->created_at}}</td>
        </tr>
        </tbody>
    </table>
@endsection
