<?php

namespace Expand\Express\kuaidi100;

use Expand\Express\ExpressInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Express implements ExpressInterface
{
    protected $config;

    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();

        $this->config = config('express.api_list.kuaidi100.config');
    }

    public function query($code, $type): array
    {
        $cacheKey = $type . '_' . $code;
        $data = Cache::get($cacheKey);

        if (!$data) {

            $api = "https://poll.kuaidi100.com/poll/query.do";
            $param = json_encode([
                'com' => $type,
                'num' => $code,
                'resultv2' => '4'
            ], JSON_UNESCAPED_UNICODE);

            $response = $this->httpClient->request("POST", $api, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'customer' => $this->config['customer'],
                    'sign' => strtoupper(md5($param . $this->config['key'] . $this->config['customer'])),
                    'param' => $param,
                ]
            ]);

            $content = $response->getBody()->getContents();

            $array = json_decode($content, true);

            $data = $array['data'] ?? [];

            Cache::put($cacheKey, $data, 1800);
        }

        return $data;
    }
}
