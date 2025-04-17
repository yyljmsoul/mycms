<?php

namespace Modules\Mp\Models;

use App\Models\MyModel;

class MpPushLogModel extends MyModel
{
    protected $table = 'my_mp_push_log';

    public function account(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne("Modules\Mp\Models\MpAccountModel", "app_id", "appid");
    }
}
