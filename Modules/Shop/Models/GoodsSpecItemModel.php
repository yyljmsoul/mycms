<?php

namespace Modules\Shop\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsSpecItemModel extends MyModel
{
    protected $table = 'my_shop_goods_spec_item';

    public function values(): HasMany
    {
        return $this->hasMany('Modules\Shop\Models\GoodsSpecValueModel','spec_id','id');
    }
}
