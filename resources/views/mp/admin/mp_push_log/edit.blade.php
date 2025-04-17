@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">任务名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="请输入任务名称"
                       value="{{$data->name}}">
                <tip>填写任务名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">文章ID</label>
            <div class="col-sm-10">
                <input type="text" name="article_id" class="form-control" placeholder="请输入文章ID"
                       value="{{$data->article_id}}">
                <tip>填写文章ID。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">发布账号</label>
            <div class="col-sm-10">
                @foreach(mpAccounts() as $account)
                    <div class="form-check col-md-2">
                        <input type="radio" class="form-check-input" id="appid-{{$account->app_id}}" name="appid"
                               value="{{$account->app_id}}" @if($data->app_id == $account->appid) checked @endif>
                        <label class="form-check-label" for="appid-{{$account->app_id}}">
                            {{$account->name}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms"></label>
            <div class="col-sm-10">
                <tip>保存后会将文章上传至公众平台素材库，暂时不会进行群发</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
