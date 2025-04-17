@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">名称</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="请输入名称" value="{{$data->name}}">
                <tip>填写名称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">平台类型</label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                    <option value="0">请选择平台类型</option>
                    @foreach(config('mp.platform') as $mpIdent => $mpName)
                        <option value="{{$mpIdent}}" @if($data->type == $mpIdent) selected @endif>{{$mpName}}</option>
                    @endforeach
                </select>
                <tip>请选择平台类型。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AppId</label>
            <div class="col-sm-10">
                <input type="text" name="app_id" class="form-control" placeholder="请输入AppId"
                       value="{{$data->app_id}}">
                <tip>填写AppId。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">AppKey</label>
            <div class="col-sm-10">
                <input type="text" name="app_key" class="form-control" placeholder="请输入AppKey"
                       value="{{$data->app_key}}">
                <tip>填写AppKey。</tip>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">Token</label>
            <div class="col-sm-10">
                <input type="text" name="token" class="form-control" placeholder="请输入Token" value="{{$data->token}}">
                <tip>填写Token。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">aes_key</label>
            <div class="col-sm-10">
                <input type="text" name="aes_key" class="form-control" placeholder="请输入aes_key" value="{{$data->aes_key}}">
                <tip>填写aes_key。</tip>
            </div>
        </div>


        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
