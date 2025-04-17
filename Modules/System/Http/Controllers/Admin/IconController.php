<?php

namespace Modules\System\Http\Controllers\Admin;

use App\Http\Controllers\MyController;

class IconController extends MyController
{
    public function index($ident)
    {
        return $this->view("admin.icons.{$ident}");
    }
}
