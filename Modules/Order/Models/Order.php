<?php

namespace Modules\Order\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends MyModel
{
    protected $table = 'my_order';

    const ORDER_STATUS_WAIT_PAY = 0;
    const ORDER_STATUS_WAIT_DELIVER = 1;
    const ORDER_STATUS_WAIT_RECEIVE = 2;
    const ORDER_STATUS_FINISH = 3;
    const ORDER_STATUS_CANCEL = 4;
    const ORDER_STATUS_REFUND = 5;
    const ORDER_STATUS_TEXT = [
        '待支付', '待发货', '待收货', '已完成', '已取消', '已退款'
    ];

    const PAY_STATUS_WAIT = 0;
    const PAY_STATUS_FINISH = 1;
    const PAY_STATUS_TEXT = [
        '待支付', '已支付'
    ];

    const DELIVERY_STATUS_WAIT = 0;
    const DELIVERY_STATUS_FINISH = 1;
    const DELIVERY_STATUS_TEXT = [
        '待发货', '已发货'
    ];

    public function user(): HasOne
    {
        return $this->hasOne('Modules\User\Models\User', 'id', 'user_id');
    }

    public function goods(): HasMany
    {
        return $this->hasMany('Modules\Order\Models\OrderGoods', 'order_id', 'id');
    }

    public function province(): HasOne
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'receive_province');
    }

    public function city(): HasOne
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'receive_city');
    }

    public function district(): HasOne
    {
        return $this->hasOne('Modules\System\Models\Region', 'id', 'receive_district');
    }
}
