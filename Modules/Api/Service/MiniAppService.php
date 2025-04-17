<?php

namespace Modules\Api\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class MiniAppService
{

    protected $appid;

    protected $secret;

    public function __construct($params = [])
    {
        $config = system_config(['mini_app_appid', 'mini_app_secret']);

        $this->appid = $params['appid'] ?? $config['mini_app_appid'];
        $this->secret = $params['secret'] ?? $config['mini_app_secret'];

    }

    /**
     * @throws GuzzleException
     */
    public function code2Session($code)
    {

        if ($this->appid && $this->secret) {

            $client = new Client(['verify' => false, 'http_errors' => false]);

            $response = $client->get("https://api.weixin.qq.com/sns/jscode2session?appid={$this->appid}&secret={$this->secret}&js_code={$code}&grant_type=authorization_code");

            $content = $response->getBody()->getContents();

            $array = json_decode($content, true);

            return !isset($array['errcode']) ? $array : false;
        }

        return false;
    }


    /**
     * 获取手机号码
     * @param $code
     * @return false|mixed
     * @throws GuzzleException
     */
    public function getPhoneNumber($code)
    {
        $token = $this->getAccessToken();
        $client = new Client(['verify' => false, 'http_errors' => false]);

        $response = $client->post("https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=$token", [
            'body' => json_encode([
                'code' => $code,
            ])
        ]);

        $content = $response->getBody()->getContents();
        $array = json_decode($content, true);

        return $array['errcode'] == 0 ? $array['phone_info']['purePhoneNumber'] : false;
    }

    /**
     * @return false|mixed
     * @throws GuzzleException
     */
    public function getAccessToken()
    {

        if ($token = Cache::get('mini_app_access_token_' . $this->appid)) {

            return $token;
        }

        if ($this->appid && $this->secret) {

            $client = new Client(['verify' => false, 'http_errors' => false]);

            $response = $client->get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}");

            $content = $response->getBody()->getContents();

            $array = json_decode($content, true);

            $token = $array['access_token'] ?? '';

            Cache::put('mini_app_access_token_' . $this->appid, $token, 7000);

            return $token;
        }

        return false;
    }
}
