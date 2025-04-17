<?php

namespace Expand\Api;

use GuzzleHttp\Client;

class ApiBaseHandle
{

    public $method;

    public $params = [];

    public $required_params = [];

    public $json_params = [];

    public $validate_token = false;

    public $user_id;

    /**
     * @param $url
     * @param $option
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpGet($url, $option = [])
    {
        $client = new Client();
        $response = $client->get($url, $option);
        $content = $response->getBody()->getContents();

        return json_decode($content, true);

    }


    /**
     * @param $url
     * @param $option
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpPost($url, $option = [])
    {
        $client = new Client();
        $response = $client->post($url, $option);
        $content = $response->getBody()->getContents();

        return json_decode($content, true);

    }
}
