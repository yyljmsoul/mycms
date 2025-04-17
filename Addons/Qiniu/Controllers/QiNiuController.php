<?php

namespace Addons\Qiniu\Controllers;

use Addons\Qiniu\Requests\QiNiuConfigRequest;
use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Storage;

class QiNiuController extends MyController
{
    public function config()
    {
        $systemConfig = system_config([], 'qiniu');
        return $this->view('admin.config', compact('systemConfig'));
    }

    public function store(QiNiuConfigRequest $request)
    {
        $data = $request->validated();

        $result = system_config_store($data, 'qiniu');

        $data['driver'] = 'qiniu';

        Storage::disk("root")->put(
            'Addons/Qiniu/Config/config.php',
            "<?php return " . var_export($data, true) . "; ?>"
        );

        return $this->result($result);
    }
}
