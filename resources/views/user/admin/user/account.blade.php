@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" readonly value="{{$user->name}}">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">余额</label>
            <div class="col-sm-10">
                <input type="text" name="balance" class="form-control"
                       placeholder="请输入变动金额" value="0">
                <tip>当前余额{{$user->balance}}。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">积分</label>
            <div class="col-sm-10">
                <input type="text" name="point" class="form-control"
                       placeholder="请输入变动积分" value="0">
                <tip>当前余额{{$user->point}}。</tip>
            </div>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">备注信息</label>
            <div class="col-sm-10">
                <textarea name="description" class="form-control" placeholder="请输入备注信息"></textarea>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="id" value="{{$user->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
