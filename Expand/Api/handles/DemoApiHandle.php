<?php

namespace Expand\Api\handles;

use Expand\Api\ApiBaseHandle;
use Expand\Api\ApiHandleInterface;

class DemoApiHandle extends ApiBaseHandle implements ApiHandleInterface
{

    public $method = 'GET';

    public $required_params = [
        'name',
    ];

    public function handle($params): array
    {
        return ['content' => 'PHP是全宇宙最好的语言'];
    }

    public function getName(): string
    {
        return '自定义接口示例';
    }
}
