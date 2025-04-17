<?php

namespace Modules\Mp\Models;

use App\Models\MyModel;

class MpCodeModel extends MyModel
{
    protected $table = 'my_mp_code';

    public function mp()
    {
        return $this->hasOne('Modules\Mp\Models\MpAccountModel', 'id', 'mp_id');
    }
}
