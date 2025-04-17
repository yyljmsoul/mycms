<?php

namespace Expand\Pay\miniapp;

use Expand\Pay\PayInterface;
use Illuminate\Http\JsonResponse;
use Modules\Order\Models\Order;
use Yansongda\Pay\Exception\ContainerDependencyException;
use Yansongda\Pay\Exception\ContainerException;
use Yansongda\Pay\Exception\InvalidParamsException;
use Yansongda\Pay\Exception\ServiceNotFoundException;
use Yansongda\Pay\Pay as PayUtils;

class Pay extends \Expand\Pay\wechat\Pay
{

    public $config;

    public $payType = 'miniapp';

    public function __construct()
    {

        parent::__construct();

        $defaultConfig = config('pay.config');
        $config = system_config(['mini_app_appid', 'wechat_mch_id', 'wechat_mch_secret_key']);

        $defaultConfig['wechat']['default'] = array_merge($defaultConfig['wechat']['default'], [
            'mch_id' => strval($config['wechat_mch_id']),
            'mch_secret_key' => $config['wechat_mch_secret_key'],
            'notify_url' => route('store.pay.notify', ['type' => $this->payType]),
            'mini_app_id' => $config['mini_app_appid'],
        ]);

        $this->config = $defaultConfig;
    }
}
