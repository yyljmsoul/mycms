<?php


namespace Modules\System\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\JsonResponse;
use Modules\System\Http\Requests\ConfigRequest;

class ConfigController extends MyController
{

    /**
     * 系统配置页面
     */
    public function index()
    {
        $systemConfig = system_config();
        return $this->view('admin.config.config', compact('systemConfig'));
    }

    /**
     * 保存系统配置
     */
    public function store(ConfigRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['lang'] = $data['lang'] ?? [];

        $result = system_config_store($data, 'system');

        return $this->result($result);
    }
}
