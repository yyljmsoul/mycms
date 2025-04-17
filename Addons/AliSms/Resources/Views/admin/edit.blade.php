@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AccessKey</label>
            <div class="col-sm-10">
                <input type="text" name="access_key" class="form-control" lay-verify="required"
                       lay-reqtext="请输入AccessKey" placeholder="请输入名称" value="{{$sms->access_key}}">
                <tip>填写AccessKey。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AccessSecret</label>
            <div class="col-sm-10">
                <input type="text" name="access_secret" class="form-control" lay-verify="required"
                       lay-reqtext="请输入AccessSecret" placeholder="请输入AccessSecret"
                       value="{{$sms->access_secret}}">
                <tip>填写AccessSecret。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">短信签名</label>
            <div class="col-sm-10">
                <input type="text" name="sign_name" class="form-control" lay-verify="required" lay-reqtext="请输入短信签名"
                       placeholder="请输入短信签名" value="{{$sms->sign_name}}">
                <tip>填写短信签名。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">短信模板</label>
            <div class="col-sm-10">
                <input type="text" name="template_code" class="form-control" lay-verify="required" lay-reqtext="请输入短信模板"
                       placeholder="请输入短信模板" value="{{$sms->template_code}}">
                <tip>填写短信模板。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">默认模板</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_default1"
                           name="is_default" @if($sms->is_default == 1) checked @endif
                           value="1">
                    <label class="form-check-label" for="is_default1">
                        是
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_default0"
                           name="is_default" @if($sms->is_default == 0) checked @endif
                           value="0">
                    <label class="form-check-label" for="is_default0">
                        否
                    </label>
                </div>
            </div>
        </div>


        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$sms->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
