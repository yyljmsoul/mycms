@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">
        @csrf
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">access</label>
            <div class="col-sm-10">
                <input type="text" name="qn_access" class="form-control" lay-verify="required"
                       placeholder="请输入access" value="{{$systemConfig['qn_access'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">secret</label>
            <div class="col-sm-10">
                <input type="text" name="qn_secret" class="form-control" lay-verify="required"
                       placeholder="请输入secret" value="{{$systemConfig['qn_secret'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">bucket</label>
            <div class="col-sm-10">
                <input type="text" name="qn_bucket" class="form-control" placeholder="请输入bucket"
                       value="{{$systemConfig['qn_bucket'] ?? ''}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">自定义域名</label>
            <div class="col-sm-10">
                <input type="text" name="qn_url" class="form-control" placeholder="请输入自定义域名"
                       value="{{$systemConfig['qn_url'] ?? ''}}">
                <tip>需包含 http/https</tip>
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
