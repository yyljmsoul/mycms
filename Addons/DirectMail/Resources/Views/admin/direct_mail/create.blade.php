@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AccessKey</label>
            <div class="col-sm-10">
                <input type="text" name="access_key" class="form-control" lay-verify="required"
                       lay-reqtext="请输入AccessKey" placeholder="请输入AccessKey" value="">
                <tip>填写AccessKey。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AccessSecret</label>
            <div class="col-sm-10">
                <input type="text" name="access_secret" class="form-control" lay-verify="required"
                       lay-reqtext="请输入AccessSecret" placeholder="请输入AccessSecret" value="">
                <tip>填写AccessSecret。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">发信地址</label>
            <div class="col-sm-10">
                <input type="text" name="account_name" class="form-control" lay-verify="required" lay-reqtext="请输入发信地址"
                       placeholder="请输入发信地址" value="">
                <tip>填写发信地址。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">默认模板</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_default1"
                           name="is_default"
                           value="1">
                    <label class="form-check-label" for="is_default1">
                        是
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="is_default0"
                           name="is_default" checked
                           value="0">
                    <label class="form-check-label" for="is_default0">
                        否
                    </label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">地域</label>
            <div class="col-sm-10">
                <input type="text" name="region" class="form-control" lay-verify="required" lay-reqtext="请输入地域"
                       placeholder="请输入地域" value="">
                <tip>填写地域。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">发件别名</label>
            <div class="col-sm-10">
                <input type="text" name="alias" class="form-control" lay-verify="required" lay-reqtext="请输入发件别名"
                       placeholder="请输入发件别名" value="">
                <tip>填写发件别名。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">备注</label>
            <div class="col-sm-10">
                <textarea name="remark" class="form-control"
                          placeholder="请输入备注"></textarea>
                <tip>填写备注。</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
