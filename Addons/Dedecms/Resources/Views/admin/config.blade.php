@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">Host</label>
            <div class="col-sm-10">
                <input type="text" name="host" class="form-control" lay-verify="required" lay-reqtext="请输入Host"
                       placeholder="请输入Host" value="{{$systemConfig['host'] ?? '127.0.0.1'}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">端口</label>
            <div class="col-sm-10">
                <input type="text" name="port" class="form-control" lay-verify="required" lay-reqtext="请输入数据库端口"
                       placeholder="请输入数据库端口" value="{{$systemConfig['port'] ?? '3306'}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据库名称</label>
            <div class="col-sm-10">
                <input type="text" name="database" class="form-control" lay-verify="required" lay-reqtext="请输入数据库名称"
                       placeholder="请输入数据库名称" value="{{$systemConfig['database'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据库账号</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" lay-verify="required" lay-reqtext="请输入数据库账号"
                       placeholder="请输入数据库账号" value="{{$systemConfig['username'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">数据库密码</label>
            <div class="col-sm-10">
                <input type="text" name="password" class="form-control" lay-verify="required" lay-reqtext="请输入数据库密码"
                       placeholder="请输入数据库密码" value="{{$systemConfig['password'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">表前缀</label>
            <div class="col-sm-10">
                <input type="text" name="dede_prefix" class="form-control"
                       value="{{$systemConfig['dede_prefix'] ?? 'dede_'}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">单次导入数据</label>
            <div class="col-sm-10">
                <input type="text" name="batch_number" class="form-control"
                       value="{{$systemConfig['batch_number'] ?? 100}}">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
