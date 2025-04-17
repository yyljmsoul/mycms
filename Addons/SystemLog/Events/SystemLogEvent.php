<?php


namespace Addons\SystemLog\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\Response;

class SystemLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $request;

    protected $response;

    public function __construct(Request $request, Response $response)
    {
        $this->param = $request;
        $this->response = $response;
    }

    public function getValues(): array
    {
        return [
            'admin_id' => auth()->guard('admin')->user()->id,
            'admin_name' => auth()->guard('admin')->user()->name,
            'url' => $this->param->path(),
            'method' => $this->param->method(),
            'is_ajax' => $this->param->ajax(),
            'ip' => get_client_ip(),
            'param' => json_encode($this->param->all()),
            'useragent' => $this->param->userAgent(),
        ];
    }
}
