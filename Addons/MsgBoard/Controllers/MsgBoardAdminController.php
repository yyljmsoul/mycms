<?php

namespace Addons\MsgBoard\Controllers;

use App\Http\Controllers\MyAdminController;

class MsgBoardAdminController extends MyAdminController
{
    public $model = 'Addons\MsgBoard\Models\MsgBoardModel';

    public $request = 'Addons\MsgBoard\Requests\MsgBoardAdminRequest';
}
