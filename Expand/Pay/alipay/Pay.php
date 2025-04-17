<?php

namespace Expand\Pay\alipay;

use App\Helpers\ResponseHelpers;
use Expand\Pay\PayInterface;
use Illuminate\Http\JsonResponse;
use Yansongda\Pay\Pay as PayUtils;

class Pay implements PayInterface
{
    use ResponseHelpers;

    public $config;

    public $payType = 'alipay';

    public function __construct()
    {

        $defaultConfig = config('pay.config');
        $config = system_config(['alipay_appid', 'alipay_secret']);

        $defaultConfig['alipay']['default'] = array_merge($defaultConfig['alipay']['default'], [
            'app_id' => strval($config['alipay_appid']),
            'app_secret_cert' => $config['alipay_secret'],
            'notify_url' => route('store.pay.notify', ['type' => $this->payType]),
        ]);

        $this->config = $defaultConfig;
    }

    /**
     * 发起支付
     * @param array $order
     * @param string $payType
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exception\ContainerDependencyException
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\ServiceNotFoundException
     */
    public function submit(array $order, $payType = ''): JsonResponse
    {
        if (isset($order['return_url']) && $order['return_url']) {
            $this->config['alipay']['default']['return_url'] = $order['return_url'];
        }

        $payType = $payType ?: $this->getPayType();

        PayUtils::config($this->config);

        $data = [
            'out_trade_no' => $order['order_sn'] . '_' . date('His'),
            'total_amount' => $order['order_amount'],
            'subject' => $order['order_sn'],
            'quit_url' => $order['cancel_url'] ?? '',
            'request_from_url' => $order['cancel_url'] ?? '',
        ];

        if ($payType == 'h5') {
            $response = PayUtils::alipay()->wap($data);
        } else {
            $response = PayUtils::alipay()->web($data);
        }

        $form = $response->getBody()->getContents();

        return $this->success(['msg' => '下单成功', 'result' => $form]);
    }

    /**
     * 回调通知
     * @param array $order
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Yansongda\Pay\Exception\ContainerDependencyException
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\InvalidParamsException
     * @throws \Yansongda\Pay\Exception\ServiceNotFoundException
     */
    public function notify(array $order = [])
    {
        PayUtils::config($this->config);
        $result = PayUtils::alipay()->callback();

        if (isset($result['out_trade_no']) && $result['out_trade_no']) {

            [$orderSn, $time] = explode("_", $result['out_trade_no']);

            orderNotifyHandle($orderSn, $this->payType, $result['trade_no']);
        }

        return PayUtils::alipay()->success();
    }

    /**
     * 退款
     * @param array $order
     * @return JsonResponse
     * @throws \Yansongda\Pay\Exception\ContainerDependencyException
     * @throws \Yansongda\Pay\Exception\ContainerException
     * @throws \Yansongda\Pay\Exception\InvalidParamsException
     * @throws \Yansongda\Pay\Exception\ServiceNotFoundException
     */
    public function refund(array $order)
    {
        PayUtils::config($this->config);

        $result = PayUtils::alipay()->refund([
            'out_trade_no' => $order['out_trade_no'],
            'refund_amount' => $order['order_amount'],
        ]);

        if (isset($result['trade_no'])) {

            return $this->success(['msg' => '退款成功', 'result' => $result]);
        }

        return $this->error(['msg' => '退款失败']);
    }

    /**
     * 获取支付类型
     * @return string
     */
    public function getPayType(): string
    {
        if (is_mobile()) {
            return 'h5';
        } else {
            return 'web';
        }
    }
}
