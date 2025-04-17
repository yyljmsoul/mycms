<?php

namespace Modules\Api\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;

class ApiProjectController extends MyAdminController
{
    public $view = 'admin.api_project.';

    public $model = 'Modules\Api\Models\ApiProjectModel';

    public $request = 'Modules\Api\Http\Requests\ApiProjectRequest';
}
