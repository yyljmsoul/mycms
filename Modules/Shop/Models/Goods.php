<?php


namespace Modules\Shop\Models;


use App\Models\MyModel;

class Goods extends MyModel
{

    protected $table = 'my_shop_goods';

    protected $langMetaKey = [
        'short_title'
    ];

    public function __get($key)
    {
        if (in_array($key, $this->langMetaKey) && $lang = current_lang()) {

            $meta = GoodsMeta::where([
                'goods_id' => $this->getAttribute('id'),
                'meta_key' => "lang_{$lang}_goods"
            ])->first();

            if ($meta) {

                $value = json_decode($meta->meta_value, true);
                return $value[$key] ?? '';
            }

            return parent::__get($key);
        }

        $meta = GoodsMeta::where([
            'goods_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? parent::langMeta($meta) : parent::__get($key);
    }

    public function category()
    {
        return $this->hasOne('Modules\Shop\Models\GoodsCategory', 'id', 'category_id');
    }

}
