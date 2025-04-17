<?php


namespace Modules\System\Models;

use App\Helpers\RepositoryHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{

    use Notifiable, RepositoryHelpers;

    protected $table = "my_system_admin";


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 角色
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne('Modules\System\Models\Role', 'id', 'role_id');
    }

    /**
     * 权限
     * @return bool
     */
    public function permission()
    {
        return in_array(
            request()->route()->uri(),
            json_decode($this->role->role_node ?: "[]", true)
        );
    }

    /**
     * 设置单项服务全局条件
     */
    protected static function boot()
    {
        parent::boot();

        if (env('IS_WE7')) {

            $uniacid = session('uniacid');

            static::addGlobalScope('avaiable', function (Builder $builder) use ($uniacid) {
                $builder->where('uniacid', '=', $uniacid);
            });
        }
    }
}
