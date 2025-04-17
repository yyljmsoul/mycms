<?php


namespace Modules\Shop\Models;


use App\Models\MyModel;

class Cart extends MyModel
{
    protected $table = 'my_shop_cart';

    public function goods()
    {
        return $this->hasOne('Modules\Shop\Models\Goods', 'id', 'goods_id');
    }
}
