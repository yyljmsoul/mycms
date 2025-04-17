<?php


namespace Addons\BingSubmitUrl\Events;


use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BingSubmitUrlEvent
{
    protected $request;

    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->param = $request;
        $this->response = $response;
    }

    public function getUrl(): string
    {
        $data = json_decode($this->response->getContent(), true);

        if ($data['status'] == 1) {

            if (isset($data['id'])) {
                return single_path($data['id']);
            }

            return $data['url'];
        }

        return '';
    }
}
