@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户名</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control"
                       placeholder="请输入用户名" value="">
                <tip>填写用户名。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户昵称</label>
            <div class="col-sm-10">
                <input type="text" name="nickname" class="form-control" value="">
                <tip>填写用户昵称。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">头像</label>
            <div class="col-sm-10 cms-upload">
                <input name="img" type="hidden" class="form-control" placeholder="请上传头像"
                       value="">
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
                       placeholder="请输入手机号码" value="">
                <tip>填写手机号码。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">openid</label>
            <div class="col-sm-10">
                <input type="text" name="openid" class="form-control" placeholder="请输入openid" value="">
                <tip>填写openid。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">unionid</label>
            <div class="col-sm-10">
                <input type="text" name="unionid" class="form-control" placeholder="请输入unionid" value="">
                <tip>填写unionid。</tip>
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
            <label class="col-sm-2 col-form-label text-end-cms">会员等级</label>
            <div class="col-sm-10">
                <select class="form-select" name="rank" id="rank">
                    <option value="0">请选择等级</option>
                    @foreach($ranks as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
