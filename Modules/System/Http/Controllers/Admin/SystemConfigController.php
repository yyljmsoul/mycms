<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;

class SystemConfigController extends MyAdminController
{
    public $view = 'admin.system_config.';

    public $model = 'Modules\System\Models\SystemConfigModel';

    public $request = 'Modules\System\Http\Requests\SystemConfigRequest';
}
