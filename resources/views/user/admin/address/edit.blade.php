@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       placeholder="请输入用户名" readonly value="{{$data->user ? $data->user->name : '用户已被删除'}}">
                <tip>填写用户名。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">收货人</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control"
                       placeholder="请输入收货人" value="{{$data->name}}">
                <tip>填写收货人。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">联系电话</label>
            <div class="col-sm-10">
                <input type="text" name="telephone" class="form-control"
                       placeholder="请输入联系电话" value="{{$data->telephone}}">
                <tip>填写联系电话。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">省/市/县</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-control-inline">
                            <select class="form-select" name="province_id" id="province_id">
                                <option value="">请选择省份</option>
                                @foreach($provinces as $item)
                                    <option value="{{$item->id}}"
                                            @if($item->id == $data->province_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-control-inline">
                            <select class="form-select" name="city_id" id="city_id">
                                <option value="">请选择城市</option>
                                @foreach($cities as $item)
                                    <option value="{{$item->id}}"
                                            @if($item->id == $data->city_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-control-inline">
                            <select class="form-select" name="district_id" id="district_id">
                                <option value="">请选择区县</option>
                                @foreach($districts as $item)
                                    <option value="{{$item->id}}"
                                            @if($item->id == $data->district_id) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">详细地址</label>
            <div class="col-sm-10">
                    <textarea name="address" class="form-control"
                              placeholder="请输入详细地址">{{$data->address}}</textarea>
                <tip>填写详细地址。</tip>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">默认地址</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" @if(0 == $data->is_default) checked
                           @endif id="is_default_0" name="is_default" checked value="0">
                    <label class="form-check-label" for="is_default_0">
                        否
                    </label>
                </div>

                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" @if(1 == $data->is_default) checked
                           @endif id="is_default_1" name="is_default" value="1">
                    <label class="form-check-label" for="is_default_1">
                        是
                    </label>
                </div>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <input type="hidden" name="user_id" value="{{$data->user_id}}">
            <input type="hidden" name="id" value="{{$data->id}}">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
@section('extend-javascript')
    <script>
        myAdmin.listen();

        $("#province_id").change(function () {

            $.get("/admin/user/address/areas?pid=" + $(this).val(), function (result) {

                let html = '<option value="0">请选择城市</option>';

                for (let i = 0; i < result.data.length; i++) {

                    html += '<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>';
                }

                $('select[name="city_id"]').html(html);

                $('select[name="district_id"]').html('<option value="0">请选择区县</option>');

            });
        });

        $("#city_id").change(function () {

            $.get("/admin/user/address/areas?pid=" + $(this).val(), function (result) {

                let html = '<option value="0">请选择区县</option>';

                for (let i = 0; i < result.data.length; i++) {

                    html += '<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>';
                }

                $('select[name="district_id"]').html(html);

            });
        });
    </script>
@endsection
