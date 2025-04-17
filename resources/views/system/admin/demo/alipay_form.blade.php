@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">支付金额</label>
            <div class="col-sm-10">
                <input type="text" name="money" class="form-control"
                       placeholder="请输入支付金额" value="0.01">
                <tip>填写支付金额。</tip>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label text-end-cms">支付方式</label>
            <div class="col-sm-10">
                <select class="form-select" name="pay_type">
                    <option value="web">电脑端</option>
                    <option value="h5">手机端</option>
                </select>
            </div>
        </div>

        <div class="hr-line"></div>
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary waves-effect waves-light" data-refresh="false">确认</button>
            <button type="reset" class="btn btn-light waves-effect">重置</button>
        </div>

        <div class="row mb-3 layui-form-text">
            <label class="col-sm-2 col-form-label text-end-cms">支付参数结果</label>
            <div class="col-sm-10">
                <textarea id="param_result"
                          class="form-control" rows="7"></textarea>
                <tip>
                    支付宝的相比微信的简单一些，直接将返回的HTML输出到页面即可<br>
                    支付宝文档：<a href="https://open.alipay.com/api" target="_blank">https://open.alipay.com/api</a>
                </tip>
            </div>
        </div>

    </form>
@endsection
@section('extend-javascript')
    <script>
        myAdmin.form('#app-form', function (res) {
            $('#param_result').val(JSON.stringify(res));
        });
    </script>
@endsection
