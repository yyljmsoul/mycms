<?php

namespace Expand\Pay\wechat;

use App\Helpers\ResponseHelpers;
use Expand\Pay\PayInterface;
use Illuminate\Http\JsonResponse;
use Modules\Order\Models\Order;
use Yansongda\Pay\Exception\ContainerDependencyException;
use Yansongda\Pay\Exception\ContainerException;
use Yansongda\Pay\Exception\InvalidParamsException;
use Yansongda\Pay\Exception\ServiceNotFoundException;
use Yansongda\Pay\Pay as PayUtils;

class Pay implements PayInterface
{

    use ResponseHelpers;

    public $config;

    public $payType = 'wechat';

    public function __construct()
    {

        $defaultConfig = config('pay.config');
        $config = system_config(['mp_app_id', 'wechat_mch_id', 'wechat_mch_secret_key']);

        $defaultConfig['wechat']['default'] = array_merge($defaultConfig['wechat']['default'], [
            'mch_id' => strval($config['wechat_mch_id']),
            'mch_secret_key' => $config['wechat_mch_secret_key'],
            'notify_url' => route('store.pay.notify', ['type' => $this->payType]),
            'mp_app_id' => $config['mp_app_id'],
        ]);

        $this->config = $defaultConfig;
    }

    /**
     * @param array $order
     * @param string $payType
     * @return JsonResponse
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws ServiceNotFoundException
     */
    public function submit(array $order, $payType = ''): JsonResponse
    {
        $errorMsg = '';
        $result = $response = [];
        PayUtils::config($this->config);

        $payOrder = [
            'out_trade_no' => $order['order_sn'] . '_' . date('His'),
            'description' => $order['order_sn'],
            'amount' => [
                'total' => $order['order_amount'] * 100,
            ],
            'payer' => [
                'openid' => $order['user']['openid'] ?? ''
            ]
        ];


        try {

            if ($this->payType == 'miniapp') {
                $payType = $this->payType;
            } else {
                $payType = $payType ?: $this->getPayType();
            }

            $payType = $payType ?: $this->getPayType();
            switch ($payType) {
                case 'h5':
                    $payOrder['scene_info'] = [
                        'payer_client_ip' => get_client_ip(),
                        'h5_info' => [
                            'type' => 'Wap',
                        ]
                    ];
                    $result = PayUtils::wechat()->wap($payOrder);
                    break;
                case 'web':
                    $result = PayUtils::wechat()->scan($payOrder);
                    break;
                case 'mp':
                    $result = PayUtils::wechat()->mp($payOrder);
                    break;
                case 'miniapp':
                    $result = PayUtils::wechat()->mini($payOrder);
                    break;
                default:
                    $result = PayUtils::wechat()->app($payOrder);
                    break;
            }

        } catch (\Exception $exception) {
            $errorMsg = $exception->getMessage();
        }

        if ($result) {

            $response = array_merge(
                json_decode(json_encode($result), true),
                ['code' => 200]
            );

            $response['order_sn'] = $order['order_sn'];
            $response['trade_no'] = $payOrder['out_trade_no'];
            $response['amount'] = $order['order_amount'];
            $response['pay_type'] = $payType;
        }

        return isset($response['code']) && $response['code'] == 200 ?
            $this->success(['msg' => '下单成功', 'result' => $response]) :
            $this->error(['msg' => $errorMsg]);
    }


    /**
     * 退款
     * @throws InvalidParamsException
     * @throws ContainerDependencyException
     * @throws ServiceNotFoundException
     * @throws ContainerException
     */
    public function refund(array $order): JsonResponse
    {
        PayUtils::config($this->config);

        $refundOrder = [
            'transaction_id' => $order['out_trade_no'],
            'out_refund_no' => $order['order_sn'] . date('His'),
            'amount' => [
                'refund' => $order['order_amount'] * 100,
                'total' => $order['order_amount'] * 100,
                'currency' => 'CNY',
            ],
        ];

        $result = PayUtils::wechat()->refund($refundOrder);

        if (isset($result['refund_id'])) {

            Order::where('order_sn', $order['out_trade_no'])->update([
                'refund_time' => time(),
            ]);

            return $this->success(['msg' => '退款成功', 'result' => $result]);
        }

        return $this->error(['msg' => '退款失败']);
    }

    /**
     * 回调通知
     * @param array $order
     * @return false|\Psr\Http\Message\ResponseInterface|void
     * @throws ContainerDependencyException
     * @throws ContainerException
     * @throws InvalidParamsException
     * @throws ServiceNotFoundException
     */
    public function notify(array $order = [])
    {
        PayUtils::config($this->config);

        $wechat = PayUtils::wechat();

        $result = $wechat->callback();

        if ($result->count() > 0) {

            $array = $result->resource;

            [$orderSn, $time] = explode("_", $array['ciphertext']['out_trade_no']);

            $response = orderNotifyHandle($orderSn, $this->payType, $array['ciphertext']['transaction_id']);

            return $response ? $wechat->success() : false;
        }
    }

    /**
     * 获取支付类型
     * @return string
     */
    public function getPayType(): string
    {
        if (is_wechat()) {
            return 'mp';
        } elseif (is_pc()) {
            return 'web';
        } elseif (is_mobile()) {
            return 'pc';
        } else {
            return 'app';
        }
    }
}
