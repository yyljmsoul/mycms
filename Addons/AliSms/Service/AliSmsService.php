<?php


namespace Addons\AliSms\Service;


use Addons\AliSms\Models\AliSmsLog;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliSmsService
{

    public function send($accessKey, $accessSecret, $mobile, $sign, $template, $params = []): array
    {
        AlibabaCloud::accessKeyClient($accessKey, $accessSecret)
            ->regionId('cn-shenzhen')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $mobile,
                        'SignName' => $sign,
                        'TemplateCode' => $template,
                        'TemplateParam' => json_encode($params),
                    ],
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException|ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }

    public function log($smsId, $mobile, $params, $response)
    {
        $log = new AliSmsLog();
        $log->store([
            'sms_id' => $smsId,
            'mobile' => $mobile,
            'params' => json_encode($params),
            'response' => $response,
        ]);
    }
}
