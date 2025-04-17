<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Http\JsonResponse;
use Modules\Shop\Http\Requests\ShopConfigRequest;

class ShopConfigController extends MyController
{
    public function index()
    {
        $systemConfig = system_config([], 'shop');

        return $this->view('admin.config.config', compact('systemConfig'));
    }

    /**
     * 保存系统配置
     */
    public function store(ShopConfigRequest $request): JsonResponse
    {
        $data = $request->validated();

        $result = system_config_store($data, 'shop');

        return $this->result($result);
    }
}
