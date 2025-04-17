<?php


namespace Modules\User\Models;


use App\Models\MyModel;

class UserAddress extends MyModel
{
    protected $table = 'my_user_address';

    public function user()
    {
        return $this->hasOne('Modules\User\Models\User','id','user_id');
    }

    public function province()
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'province_id');
    }

    public function city()
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'city_id');
    }

    public function district()
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'district_id');
    }
}
