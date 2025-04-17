@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#base" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">商城设置</span>
                </a>
            </li>
        </ul>
        <div class="tab-content p-3 text-muted">

            <div class="tab-pane active" id="base" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商城名称</label>
                    <div class="col-sm-10">
                        <input type="text" name="shop_name" class="form-control"
                               placeholder="请输入商城名称" value="{{$systemConfig['shop_name'] ?? ''}}">
                        <tip>填写商城名称</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">热门搜索词</label>
                    <div class="col-sm-10">
                                <textarea name="search_hot_keywords"
                                          class="form-control">{{$systemConfig['search_hot_keywords'] ?? ''}}</textarea>
                        <tip>热门搜索词，多个换行输入</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">包邮条件</label>
                    <div class="col-sm-10">
                        <input name="system_freight_total" class="form-control"
                               value="{{$systemConfig['system_freight_total'] ?? ''}}">
                        <tip>满多少钱包邮，不填均需要邮费</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">运费金额</label>
                    <div class="col-sm-10">
                        <input name="system_freight_money" class="form-control"
                               value="{{$systemConfig['system_freight_money'] ?? ''}}">
                        <tip>订单运费金额</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">客服电话</label>
                    <div class="col-sm-10">
                        <input type="text" name="shop_service_telephone" class="form-control"
                               placeholder="请输入客服电话"
                               value="{{$systemConfig['shop_service_telephone'] ?? ''}}">
                        <tip>填写客服电话</tip>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">工作时间</label>
                    <div class="col-sm-10">
                        <input type="text" name="shop_work_time" class="form-control"
                               placeholder="请输入工作时间" value="{{$systemConfig['shop_work_time'] ?? ''}}">
                        <tip>填写工作时间</tip>
                    </div>
                </div>

            </div>

            <div class="hr-line"></div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary waves-effect waves-light"
                        data-refresh="false">确认
                </button>
                <button type="reset" class="btn btn-light waves-effect">重置</button>
            </div>

        </div>
    </form>
@endsection
