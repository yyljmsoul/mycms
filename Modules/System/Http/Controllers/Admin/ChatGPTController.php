<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ChatGPTController extends MyController
{
    public function demo()
    {
        return $this->view("admin.chat_gpt.demo");
    }

    /**
     * @throws GuzzleException
     */
    public function question(): \Illuminate\Http\JsonResponse
    {
        $q = $this->param('q');

        $client = new Client();
        $response = $client->post("https://api.openai.com/v1/chat/completions", [
            'body' => '{"model": "gpt-3.5-turbo","messages": [{"role": "user", "content": "' . $q . '"}]}',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('CG_KEY'),
            ]
        ]);

        $content = $response->getBody()->getContents();
        $result = json_decode($content, true);

        return $this->success(['result' => ($result["choices"][0]['message']["content"] ?? '')]);
    }
}
