@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form" class="layui-form layuimini-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">登录账户</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" readonly value="{{$admin->name}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">登录密码</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control"
                       placeholder="请输入登录密码" value="">
                <tip>填写登录密码。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">确认密码</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation" class="form-control"
                       placeholder="请输入确认密码" value="">
                <tip>填写再次登录密码。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$admin->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
