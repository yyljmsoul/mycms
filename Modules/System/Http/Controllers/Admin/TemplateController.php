<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Storage;

class TemplateController extends MyController
{
    public function config()
    {
        $lang = system_config('lang') ?: [];
        $configs = config('template.system') ?: [];

        return $this->view('admin.template.config', compact('configs', 'lang'));
    }

    /**
     * 将配置写入文件
     */
    public function store(): \Illuminate\Http\JsonResponse
    {
        $result = [];
        $lang = system_config('lang') ?: [];
        $configs = config('template.system') ?: [];
        $theme = system_config('cms_theme') ?? 'default';

        foreach ($configs as $cfg) {

            $data = request()->input($cfg['page']);

            if (count($lang) > 0) {
                foreach ($data as $key => $values) {
                    foreach ($values as $ident => $item) {
                        $result[$cfg['page']][$key][$ident] = $item;
                    }
                }
            } else {
                foreach ($data as $key => $val) {
                    $result[$cfg['page']][$key] = $val;
                }
            }
        }

        Storage::disk('root')->put(
            "Template/{$theme}/config/template_config.php",
            "<?php \n return " . var_export($result, true) . ";"
        );

        return $this->result();
    }
}
