<?php

namespace Modules\Shop\Service;

use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsAlbums;
use Modules\Shop\Models\GoodsMeta;
use Modules\Shop\Models\GoodsMobileImagesModel;
use Modules\Shop\Models\GoodsSpecItemModel;
use Modules\Shop\Models\GoodsSpecModel;
use Modules\Shop\Models\GoodsSpecValueModel;

class GoodsService
{
    public function destroyGoods($id)
    {
        $condition = [
            ['goods_id', '=', $id]
        ];

        Goods::destroy($id);
        GoodsAlbums::where($condition)->delete();
        GoodsMeta::where($condition)->delete();
        GoodsMobileImagesModel::where($condition)->delete();
        GoodsSpecModel::where($condition)->delete();
        GoodsSpecItemModel::where($condition)->delete();
        GoodsSpecValueModel::where($condition)->delete();
    }
}
