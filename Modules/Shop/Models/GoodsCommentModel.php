<?php

namespace Modules\Shop\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsCommentModel extends MyModel
{
    protected $table = 'my_shop_goods_comment';

    public function resource(): HasMany
    {
        return $this->hasMany('Modules\Shop\Models\GoodsCommentResourceModel', 'comment_id', 'id');
    }
}
