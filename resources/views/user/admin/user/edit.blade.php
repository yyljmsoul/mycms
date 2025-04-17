@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{$user->name}}">
                <tip>填写用户名。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户昵称</label>
            <div class="col-sm-10">
                <input type="text" name="nickname" class="form-control" value="{{$user->nickname}}">
                <tip>填写用户昵称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">头像</label>
            <div class="col-sm-10 cms-upload">
                <input name="img" type="hidden" class="form-control" placeholder="请上传头像"
                       value="{{$user->img}}">
                <input type="file" class="form-control" data-name="img" cms-upload data-max-size="2"
                       data-upload-exts=".ico,.png,.jpg,.jpeg">
                <div class="my-1 upload-thumb">
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">手机号码</label>
            <div class="col-sm-10">
                <input type="text" name="mobile" class="form-control"
                       placeholder="请输入手机号码" value="{{$user->mobile}}">
                <tip>填写手机号码。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">openid</label>
            <div class="col-sm-10">
                <input type="text" name="openid" class="form-control" placeholder="请输入openid"
                       value="{{$user->openid}}">
                <tip>填写openid。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">unionid</label>
            <div class="col-sm-10">
                <input type="text" name="unionid" class="form-control" placeholder="请输入unionid"
                       value="{{$user->unionid}}">
                <tip>填写unionid。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">会员等级</label>
            <div class="col-sm-10">
                <select class="form-select" name="rank" id="rank">
                    <option value="0">请选择等级</option>
                    @foreach($ranks as $item)
                        <option value="{{$item->id}}"
                                @if($item->id == $user->rank) selected @endif >{{$item->name}}</option>
                    @endforeach
                </select>
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
