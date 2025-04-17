<?php

use Addons\AliSms\Models\AliSms;
use Addons\AliSms\Service\AliSmsService;

if (!function_exists('ali_sms')) {
    function ali_sms($mobile, $smsId = 0, $params = []): bool
    {

        $sms = $smsId == 0 ? AliSms::where('is_default', 1)->first() : AliSms::find($smsId);

        $service = new AliSmsService();
        $result = $service->send($sms->access_key, $sms->access_secret, $mobile, $sms->sign_name, $sms->template_code, $params);
        $service->log($sms->id, $mobile, $params, $result['Message']);

        return $result['Code'] == 'OK' && $result['Message'] == 'OK';
    }
}
