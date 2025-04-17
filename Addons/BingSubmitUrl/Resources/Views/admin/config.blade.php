@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">API-KEY</label>
            <div class="col-sm-10">
                <input type="text" name="bing_api_key" class="form-control" lay-verify="required"
                       lay-reqtext="请输入API-KEY" placeholder="请输入API-KEY"
                       value="{{$systemConfig['bing_api_key'] ?? ''}}">
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">推送模式</label>
            <div class="col-sm-10">
                <div class="row">
                    <div class="form-check col-md-2">
                        <input type="radio" name="by_push_type" id="by_push_type_1"
                               @if(!isset($systemConfig['by_push_type']) || $systemConfig['by_push_type'] == 1) checked
                               @endif value="1">
                        <label class="form-check-label" for="by_push_type_1">
                            实时推送
                        </label>
                    </div>
                    <div class="form-check col-md-2">
                        <input type="radio" name="by_push_type" id="by_push_type_2"
                               @if(isset($systemConfig['by_push_type']) && $systemConfig['by_push_type'] == 2) checked
                               @endif value="2" title="批量推送">
                        <label class="form-check-label" for="by_push_type_2">
                            批量推送
                        </label>
                    </div>
                    <div class="form-check col-md-2">
                        <input type="radio" name="by_push_type" id="by_push_type_3"
                               @if(isset($systemConfig['by_push_type']) && $systemConfig['by_push_type'] == 3) checked
                               @endif value="3" title="关闭推送">
                        <label class="form-check-label" for="by_push_type_3">
                            关闭推送
                        </label>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">批量推送数量</label>
            <div class="col-sm-10">
                <input type="text" name="by_push_total" class="form-control" placeholder="请输入批量推送数量"
                       value="{{$systemConfig['by_push_total'] ?? 100}}">
                <tip>该参数仅对批量推送模式有效</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">批量推送地址</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" readonly value="{{route('admin.addon.bing_submit_url.crontab')}}">
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
