<?php

namespace Addons\DirectMail\Providers;

use Addons\DirectMail\Expand\SingleSendMailRequest;
use Illuminate\Mail\Transport\Transport;

require_once addon_path('DirectMail', '/Expand/aliyun-php-sdk-core/Config.php');

class DirectMailTransport extends Transport
{
    protected $region;
    protected $appKey;
    protected $appSecret;
    protected $accountName;
    protected $accountAlias;

    public function __construct($region, $appKey, $appSecret, $accountName, $accountAlias)
    {
        $this->region = $region;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->accountName = $accountName;
        $this->accountAlias = $accountAlias;
    }

    protected function createClient()
    {
        $iClientProfile = \DefaultProfile::getProfile($this->region, $this->appKey, $this->appSecret);

        return new \DefaultAcsClient($iClientProfile);
    }

    /**
     * @param \Swift_Mime_SimpleMessage $message
     * @param null $failedRecipients
     * @return int
     */
    public function send(\Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        return $this->sendSingle($message);
    }

    protected function sendSingle(\Swift_Mime_SimpleMessage $message)
    {
        $request = new SingleSendMailRequest();

        $request->setAccountName($this->accountName);    //控制台创建的发信地址
        $request->setFromAlias($this->accountAlias);
        $request->setAddressType(1);
        $request->setReplyToAddress('true');

        $request->setToAddress($this->getToAddress($message));
        $request->setSubject($message->getSubject());
        $request->setHtmlBody($message->getBody());
        // dd($message->getBody());

        $this->createClient()->getAcsResponse($request);

        return 1;
    }


    protected function getToAddress(\Swift_Mime_SimpleMessage $message): string
    {
        return implode(',', array_keys($message->getTo()));
    }
}
