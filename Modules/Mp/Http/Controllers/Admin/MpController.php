<?php

namespace Modules\Mp\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Modules\Mp\Service\MpService;

class MpController extends MyAdminController
{
    protected $service;

    public function __construct()
    {
        $this->service = new MpService();
    }
}
