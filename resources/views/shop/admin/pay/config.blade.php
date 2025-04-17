@extends("layouts.common")
@section('page-content-wrapper')
    <form id="app-form">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#wechat" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">微信支付</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#alipay" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">支付宝支付</span>
                </a>
            </li>
            {{--<li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#paypal" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Paypal</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#stripe" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block">Stripe</span>
                </a>
            </li>--}}
        </ul>
        <div class="tab-content p-3 text-muted">

            <div class="tab-pane active" id="wechat" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">小程序Appid</label>
                    <div class="col-sm-10">
                        <input type="text" name="mini_app_appid" class="form-control" placeholder="请输入小程序Appid"
                               value="{{$systemConfig['mini_app_appid'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">小程序Secret</label>
                    <div class="col-sm-10">
                        <input type="text" name="mini_app_secret" class="form-control" placeholder="请输入小程序Secret"
                               value="{{$systemConfig['mini_app_secret'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">公众号Appid</label>
                    <div class="col-sm-10">
                        <input type="text" name="mp_app_id" class="form-control" placeholder="请输入公众号Appid"
                               value="{{$systemConfig['mp_app_id'] ?? ''}}">
                    </div>
                </div>


                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商户ID</label>
                    <div class="col-sm-10">
                        <input type="text" name="wechat_mch_id" class="form-control" placeholder="请输入商户ID"
                               value="{{$systemConfig['wechat_mch_id'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商户API密钥</label>
                    <div class="col-sm-10">
                        <input type="text" name="wechat_mch_secret_key" class="form-control" placeholder="请输入商户密钥"
                               value="{{$systemConfig['wechat_mch_secret_key'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商户公钥</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/wechat 目录下，并命名为 apiclient_cert.pem">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">商户私钥</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/wechat 目录下，并命名为 apiclient_key.pem">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">微信平台公钥</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/wechat 目录下，并命名为 wechatpay_pem.pem">
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="alipay" role="tabpanel">

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">Appid</label>
                    <div class="col-sm-10">
                        <input type="text" name="alipay_appid" class="form-control" placeholder="请输入Appid"
                               value="{{$systemConfig['alipay_appid'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">Secret</label>
                    <div class="col-sm-10">
                        <input type="text" name="alipay_secret" class="form-control" placeholder="请输入Secret"
                               value="{{$systemConfig['alipay_secret'] ?? ''}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">应用公钥</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/alipay 目录下，并命名为 appCertPublicKey.crt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">支付宝公钥</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/alipay 目录下，并命名为 alipayCertPublicKey_RSA2.crt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label text-end-cms">支付宝根证书</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control"
                               value="请存放于 pem/alipay 目录下，并命名为 alipayRootCert.crt">
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
