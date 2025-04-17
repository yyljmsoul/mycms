@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">网址</label>
            <div class="col-sm-10">
                <input type="text" name="link_submit_url" class="form-control" lay-verify="required" lay-reqtext="请输入网址"
                       placeholder="请输入网址" value="{{$systemConfig['link_submit_url'] ?? ''}}">
                <tip>http://data.zz.baidu.com/urls?site=<em style="color: red">https://domain.com</em>&token=xxxxxxx
                </tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">Token</label>
            <div class="col-sm-10">
                <input type="text" name="link_submit_token" class="form-control" lay-verify="required"
                       lay-reqtext="请输入Token" placeholder="请输入Token"
                       value="{{$systemConfig['link_submit_token'] ?? ''}}">
                <tip>http://data.zz.baidu.com/urls?site=https://domain.com&token=<em style="color: red">xxxxxxx</em>
                </tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">推送模式</label>
            <div class="col-sm-10">
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="bd_push_type1"
                           name="bd_push_type" @if(!isset($systemConfig['bd_push_type']) || $systemConfig['bd_push_type'] == 1) checked
                           @endif
                           value="1">
                    <label class="form-check-label" for="bd_push_type1">
                        实时推送
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="bd_push_type2"
                           name="bd_push_type" @if(isset($systemConfig['bd_push_type']) && $systemConfig['bd_push_type'] == 2) checked
                           @endif
                           value="2">
                    <label class="form-check-label" for="bd_push_type2">
                        批量推送
                    </label>
                </div>
                <div class="form-check col-md-2">
                    <input type="radio" class="form-check-input" id="bd_push_type3"
                           name="bd_push_type" @if(isset($systemConfig['bd_push_type']) && $systemConfig['bd_push_type'] == 3) checked
                           @endif
                           value="3">
                    <label class="form-check-label" for="bd_push_type3">
                        关闭推送
                    </label>
                </div>

            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">批量推送数量</label>
            <div class="col-sm-10">
                <input type="text" name="bd_push_total" class="form-control" placeholder="请输入单日推送数量"
                       value="{{$systemConfig['bd_push_total'] ?? 1000}}">
                <tip>该参数仅对批量推送模式有效</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">批量推送地址</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" readonly value="{{route('admin.addon.link_submit.crontab')}}">
                <tip>建议加入定时任务在凌晨执行</tip>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

    </form>
@endsection
