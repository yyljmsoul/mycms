<?php

namespace Modules\Mp\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Illuminate\Support\Str;

class MpAccountController extends MpController
{
    public $view = 'admin.mp_account.';

    public $model = 'Modules\Mp\Models\MpAccountModel';

    public $request = 'Modules\Mp\Http\Requests\MpAccountRequest';


    /**
     * @param $id
     * @return void
     */
    public function afterStore($id)
    {
        $this->getModel()::where('id', $id)->update([
            'ident' => Str::random(8) . date('ds')
        ]);
    }
}
