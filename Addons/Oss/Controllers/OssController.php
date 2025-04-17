<?php


namespace Addons\Oss\Controllers;


use Addons\Oss\Requests\ConfigRequest;
use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Storage;

class OssController extends MyController
{

    public function config()
    {
        $systemConfig = system_config([], 'oss');
        return $this->view('admin.config', compact('systemConfig'));
    }

    public function store(ConfigRequest $request)
    {
        $data = $request->validated();

        $result = system_config_store($data, 'oss');

        $data['driver'] = 'oss';

        Storage::disk("root")->put(
            'Addons/Oss/Config/config.php',
            "<?php return " . var_export($data, true) . "; ?>"
        );

        return $this->result($result);
    }

}
