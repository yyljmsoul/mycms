@extends("layouts.common")
@section('page-content-wrapper')

    <form id="app-form">
        @csrf
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">accessKeyId</label>
            <div class="col-sm-10">
                <input type="text" name="oss_access_key_id" class="form-control" lay-verify="required"
                       placeholder="请输入accessKeyId"
                       value="{{$systemConfig['oss_access_key_id'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">accessKeySecret</label>
            <div class="col-sm-10">
                <input type="text" name="oss_access_key_secret" class="form-control"
                       lay-verify="required" placeholder="请输入accessKeySecret"
                       value="{{$systemConfig['oss_access_key_secret'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">endpoint</label>
            <div class="col-sm-10">
                <input name="oss_endpoint" class="form-control" placeholder="请输入endpoint"
                       value="{{$systemConfig['oss_endpoint'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">bucket</label>
            <div class="col-sm-10">
                <input type="text" name="oss_bucket" class="form-control" placeholder="请输入bucket"
                       value="{{$systemConfig['oss_bucket'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">自定义域名</label>
            <div class="col-sm-10">
                <input type="text" name="oss_url" class="form-control" placeholder="请输入自定义域名"
                       value="{{$systemConfig['oss_url'] ?? ''}}">
                <tip>需包含 http/https，不填默认链接为 {bucket}.{oss_endpoint}</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认
            </button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>

@endsection
