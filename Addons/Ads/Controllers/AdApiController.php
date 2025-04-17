<?php

namespace Addons\Ads\Controllers;

use Modules\Api\Http\Controllers\ApiController;

class AdApiController extends ApiController
{

    /**
     * 通过标识获取广告资源
     * @param $ident
     * @return \Illuminate\Http\JsonResponse
     */
    public function info($ident): \Illuminate\Http\JsonResponse
    {
        return $this->success(['result' => ad($ident)]);
    }
}
