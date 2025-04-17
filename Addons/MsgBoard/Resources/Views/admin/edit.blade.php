@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">名字</label>
            <div class="col-sm-10">
                <input type="text" name="first_name" class="form-control" value="{{$data->first_name}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">姓氏</label>
            <div class="col-sm-10">
                <input type="text" name="last_name" class="form-control" value="{{$data->last_name}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">邮箱地址</label>
            <div class="col-sm-10">
                <input type="text" name="email" class="form-control" placeholder="请输入邮箱" value="{{$data->email}}">
                <tip>填写邮箱。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">手机号码</label>
            <div class="col-sm-10">
                <input type="text" name="phone" class="form-control" placeholder="请输入手机号码"
                       value="{{$data->phone}}">
                <tip>填写手机号码。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">主题</label>
            <div class="col-sm-10">
                <input type="text" name="subject" class="form-control" placeholder="请输入主题"
                       value="{{$data->subject}}">
                <tip>填写主题。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">内容</label>
            <div class="col-sm-10">
                <textarea name="content" class="form-control" placeholder="请输入内容">{{$data->content}}</textarea>
                <tip>填写内容。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">状态</label>
            <div class="col-sm-10">
                <input type="radio" name="status" lay-skin="primary" value="1" @if($data->status == '1') checked
                       @endif title="已处理">
                <input type="radio" name="status" lay-skin="primary" value="0" @if($data->status == '0') checked
                       @endif title="待处理">
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$data->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
