<?php

namespace Modules\Mp\Models;

use App\Models\MyModel;

class MpReplyModel extends MyModel
{
    protected $table = 'my_mp_reply';

    public function mp()
    {
        return $this->hasOne('Modules\Mp\Models\MpAccountModel', 'id', 'mp_id');
    }
}
