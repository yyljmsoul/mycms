<?php


return [

    'pay_list' => [
        'balance' => [
            'name' => '余额支付'
        ],
        'miniapp' => [
            'name' => '小程序支付'
        ],
        'wechat' => [
            'name' => '微信支付'
        ],
        'alipay' => [
            'name' => '支付宝'
        ]
    ],
    'config' => [
        'wechat' => [
            'default' => [
                // 必填-商户号，服务商模式下为服务商商户号
                'mch_id' => '',
                // 必填-商户秘钥
                'mch_secret_key' => '',
                // 必填-商户私钥 字符串或路径
                'mch_secret_cert' => base_path('pem/wechat/apiclient_key.pem'),
                // 必填-商户公钥证书路径
                'mch_public_cert_path' => base_path('pem/wechat/apiclient_cert.pem'),
                // 必填
                'notify_url' => '',
                // 选填-公众号 的 app_id
                'mp_app_id' => '',
                // 选填-小程序 的 app_id
                'mini_app_id' => '',
                // 选填-app 的 app_id
                'app_id' => '',
                // 选填-合单 app_id
                'combine_app_id' => '',
                // 选填-合单商户号
                'combine_mch_id' => '',
                // 选填-服务商模式下，子公众号 的 app_id
                'sub_mp_app_id' => '',
                // 选填-服务商模式下，子 app 的 app_id
                'sub_app_id' => '',
                // 选填-服务商模式下，子小程序 的 app_id
                'sub_mini_app_id' => '',
                // 选填-服务商模式下，子商户id
                'sub_mch_id' => '',
                // 选填-微信公钥证书路径, optional，强烈建议 php-fpm 模式下配置此参数
                'wechat_public_cert_path' => [
                    'wechat_public_cert_path' => base_path('pem/wechat/wechatpay_pem.pem'),
                ],
                // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE
                'mode' => 0,
            ]
        ],
        'alipay' => [
            'default' => [
                // 必填-支付宝分配的 app_id
                'app_id' => '',
                // 必填-应用私钥 字符串或路径
                // 在 https://open.alipay.com/develop/manage 《应用详情->开发设置->接口加签方式》中设置
                'app_secret_cert' => '',
                // 必填-应用公钥证书 路径
                // 设置应用私钥后，即可下载得到以下3个证书
                'app_public_cert_path' => base_path('pem/alipay/appCertPublicKey.crt'),
                // 必填-支付宝公钥证书 路径
                'alipay_public_cert_path' => base_path('pem/alipay/alipayCertPublicKey_RSA2.crt'),
                // 必填-支付宝根证书 路径
                'alipay_root_cert_path' => base_path('pem/alipay/alipayRootCert.crt'),
                'return_url' => '',
                'notify_url' => '',
                // 选填-第三方应用授权token
                'app_auth_token' => '',
                // 选填-服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数
                'service_provider_id' => '',
                // 选填-默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE
                'mode' => 0,
            ]
        ],
        'logger' => [
            'enable' => true,
            'file' => './logs/pay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
    ]

];
