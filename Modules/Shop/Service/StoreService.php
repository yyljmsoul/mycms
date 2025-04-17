<?php


namespace Modules\Shop\Service;


use App\Service\MyService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Order\Models\Order;
use Modules\Shop\Models\Cart;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsAlbums;
use Modules\Shop\Models\GoodsCategory;
use Modules\Shop\Models\GoodsCategoryMeta;
use Modules\Shop\Models\GoodsCommentModel;
use Modules\Shop\Models\GoodsMeta;
use Modules\Shop\Models\GoodsMobileImagesModel;
use Modules\Shop\Models\GoodsSpecItemModel;
use Modules\Shop\Models\GoodsSpecModel;
use Modules\Shop\Models\PayLog;

class StoreService extends MyService
{

    /**
     * @var array
     */
    protected $condition = [];

    /**
     * 商品拓展过滤条件
     * @param array $params
     * @return StoreService
     */
    public function filterCondition(array $params = []): StoreService
    {
        if (isset($params['minPrice']) && $params['minPrice'] > -1) {
            $this->condition[] = ['shop_price', '>=', $params['minPrice']];
        }

        if (isset($params['maxPrice']) && $params['maxPrice'] > -1) {
            $this->condition[] = ['shop_price', '<', $params['maxPrice']];
        }

        return $this;
    }

    /**
     * 分类树形结构数据
     * @return array|mixed
     */
    public function categoryTree()
    {
        $data = GoodsCategory::toTree();
        return $this->tree($data);
    }

    /**
     * 分类树形结构数据（用于下拉框）
     * @return array
     */
    public function categoryTreeForSelect(): array
    {
        $data = GoodsCategory::toTree();
        return $this->treeForSelect($data);
    }

    /**
     * 子分类ID
     * @return array|int[]
     */
    public function categoryChildIds($pid = 0): array
    {
        $data = GoodsCategory::toTree();
        return $this->childIds($data, $pid, true);
    }

    /**
     * 分类详情
     * @param $id
     * @return mixed
     */
    public function categoryInfo($id)
    {
        return GoodsCategory::find($id);
    }


    /**
     * @param $orderBy
     * @param $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function goodsQuery($orderBy, $sort): \Illuminate\Database\Eloquent\Builder
    {
        return Goods::with('category:id,name')
            ->where($this->condition)->orderBy($orderBy, $sort);
    }


    /**
     * 商品列表
     * @param $page
     * @param $limit
     * @param $orderBy
     * @param $sort
     * @return LengthAwarePaginator
     */
    public function goodsList($page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        $goodsList = $this->goodsQuery($orderBy, $sort)->paginate($limit, '*', 'page', $page);

        return pipeline_func($goodsList, "goods_list");
    }


    /**
     * 搜素商品
     * @param $keyword
     * @param $page
     * @param $limit
     * @param $orderBy
     * @param $sort
     * @return LengthAwarePaginator
     */
    public function search($keyword, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        $goodsList = $this->goodsQuery($orderBy, $sort)
            ->where('goods_name', 'like', '%' . $keyword . '%')
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($goodsList, "goods_list");
    }


    /**
     * 商品详情
     * @param $id
     * @return mixed
     */
    public function goods($id)
    {
        $goods = Goods::with('category:id,name')->find($id);

        if ($goods) {

            $goods->goods_albums = $this->goodsAlbums($id);

            $mobileImages = $this->goodsMobileImages($id);
            $goods->mobile_images = $mobileImages ? array_column(
                $mobileImages->toArray(), 'path') : [];

            $goods->specList = $this->goodsSpecList($id);

            $skuList = $this->goodsSkuList($id);

            $goods->skuList = $skuList;
            $goods->stock = $skuList ? array_sum(array_column($skuList, 'stock')) : $goods->stock;

        }

        return pipeline_func($goods, "goods");
    }

    /**
     * 获取商品库存
     * @param $goodsId
     * @param $skuId
     * @return float|int
     */
    public function getGoodsStock($goodsId, $skuId = 0)
    {
        if (empty($skuId)) {

            $goods = Goods::find($goodsId);
            $skuList = $this->goodsSkuList($goodsId);

            return $skuList ? array_sum(array_column($skuList, 'stock')) : $goods->stock;

        } else {

            $spec = GoodsSpecModel::where('goods_id', $goodsId)->where('id', $skuId)->first();

            return $spec ? $spec->stock : 0;
        }
    }


    /**
     * 分类商品列表
     * @param $categoryId
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function goodsForCategory($categoryId, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        $childIds = $this->categoryChildIds($categoryId);

        $goodsList = $this->goodsQuery($orderBy, $sort)
            ->whereIn('category_id', $childIds)
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($goodsList, "goods_list");
    }

    /**
     * @param $attr
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return bool|LengthAwarePaginator
     */
    public function goodsForAttr($attr, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc')
    {
        $metas = GoodsMeta::where('meta_key', $attr)
            ->orderBy('goods_id', 'desc')
            ->select(['goods_id'])
            ->get()->toArray();

        if ($metas > 0) {

            $goodsId = array_column($metas, 'goods_id');

            $goodsList =  $this->goodsQuery($orderBy, $sort)
                ->whereIn('id', $goodsId)
                ->paginate($limit, '*', 'page', $page);

            return pipeline_func($goodsList, "goods_list");
        }

        return false;
    }

    /**
     * 根据交易号获取支付记录
     * @param $tradeNo
     * @return mixed
     */
    public function payLogForTradeNo($tradeNo)
    {
        return PayLog::where('trade_no', $tradeNo)->fisrt();
    }

    /**
     * 商品增加浏览数
     * @param $id
     * @return void
     */
    public function goodsAddView($id)
    {
        Goods::where('id', $id)->update([
            'view' => DB::raw('view + 1'),
        ]);
    }

    /**
     * 获取分类拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function categoryMeta($id, $exclude = [])
    {
        $meta = GoodsCategoryMeta::where('category_id', $id);

        $exclude = array_merge($exclude, array_map(function ($item) {
            return $item . "_goods_category";
        }, system_lang_meta()));
        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 获取商品拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function goodsMeta($id, $exclude = [])
    {
        $meta = GoodsMeta::where('goods_id', $id);

        $exclude = array_merge($exclude, array_map(function ($item) {
            return $item . "_goods";
        }, system_lang_meta()));
        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 商品相册
     * @param $id
     * @param bool $join
     * @return mixed
     */
    public function goodsAlbums($id, bool $join = false)
    {
        $albums = GoodsAlbums::where('goods_id', $id)->orderBy('id', 'asc')->get();

        return $join === false
            ? $albums
            : join("|", array_column($albums->toArray(), "goods_image"));
    }

    /**
     * 商品手机端内容详情
     * @param $id
     * @return mixed
     */
    public function goodsMobileImages($id)
    {
        return GoodsMobileImagesModel::where('goods_id', $id)
            ->select(['path'])
            ->orderBy('id', 'asc')
            ->get();
    }

    /**
     * 购物车商品列表
     * @param $uid
     * @param array $ids
     * @param int $limit
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function cart($uid, array $ids = [], int $limit = 20, int $page = 1): LengthAwarePaginator
    {
        $query = Cart::with("goods:id,goods_name,goods_image,shop_price,market_price,stock")
            ->where('user_id', $uid)
            ->orderBy('id', 'desc');

        if ($ids) {

            $query->whereIn('id', $ids);
        }

        $result = $query->paginate($limit, '*', 'page', $page)->toArray();

        foreach ($result['data'] as &$data) {

            $data['sku'] = [];
            $data['stock'] = $data['goods']['stock'];

            if ($data['sku_id']) {

                $sku = $this->getGoodsSkuInfo($data['goods_id'], $data['sku_id']);

                if ($sku) {

                    $data['sku'] = $sku->toArray();
                    $data['stock'] = $data['goods']['stock'] = $sku->stock;
                    $data['goods']['shop_price'] = $sku->shop_price;
                    $data['goods']['market_price'] = $sku->market_price;
                }
            }
        }

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $result['data'], $result['total'], $result['per_page'], $result['current_page']
        );
    }

    /**
     * 购物车统计
     * @param $uid
     * @param $ids
     * @return int[]
     */
    public function cartTotal($uid, $ids = []): array
    {
        $array = [
            'count' => 0,
            'total' => 0,
        ];

        $carts = $this->cart($uid, $ids, 100)->toArray();

        foreach ($carts['data'] as $item) {

            $array['total'] += ($item['goods']['shop_price'] * $item['number']);

            $array['count'] += $item['number'];
        }

        $array['freight'] = $this->freightTotal($array['total']);

        return $array;
    }

    /**
     * 通过商品金额计算邮费
     * @param $goodsMoney
     * @return float|int
     */
    public function freightTotal($goodsMoney)
    {
        $freight = 0;
        $config = system_config([], 'shop');

        if ($config['system_freight_money'] > 0 && $goodsMoney < $config['system_freight_total']) {

            $freight = floatval($config['system_freight_money']);
        }

        return $freight;
    }

    /**
     * 购物车统计
     * @param $uid
     * @param array $ids
     * @return mixed
     */
    public function deleteCartGoods($uid, $ids = [])
    {
        $query = Cart::where('user_id', $uid);

        if ($ids) {

            $query->whereIn('id', $ids);
        }

        return $query->delete();
    }

    /**
     * 获取SKU信息
     * @param $goodsId
     * @param $skuId
     * @return mixed
     */
    public function getGoodsSkuInfo($goodsId, $skuId)
    {
        return GoodsSpecModel::where('goods_id', $goodsId)->where('id', $skuId)->first();
    }


    /**
     * 添加商品到购物车
     * @param $uid
     * @param $goodsId
     * @param $number
     * @param int $skuId
     * @param $direct
     * @return mixed
     */
    public function goodsToCart($uid, $goodsId, $number, $skuId = 0, $direct = 0)
    {

        if (empty($skuId) && $skuList = $this->goodsSkuList($goodsId)) {

            $skuId = current($skuList)['id'];
        }

        $cart = Cart::where([
            ['user_id', '=', $uid],
            ['goods_id', '=', $goodsId],
            ['sku_id', '=', $skuId]
        ])->first();

        if ($cart) {

            $cart->number = $direct ? $number : $cart->number + $number;

            $result = $this->checkGoodsStock($goodsId, $cart->number, $skuId);

            if ($result) {

                $cart->save();
            }

        } else {

            $result = Cart::insert([
                'user_id' => $uid,
                'goods_id' => $goodsId,
                'sku_id' => $skuId,
                'number' => $number,
            ]);
        }

        return $result;
    }


    /**
     * 商品库存检查
     * @param $goodsId
     * @param $number
     * @param $skuId
     * @return bool
     */
    public function checkGoodsStock($goodsId, $number, $skuId = ''): bool
    {
        if (empty($skuId)) {

            $skuList = $this->goodsSkuList($goodsId);

            if (count($skuList) == 0) {

                $goods = Goods::find($goodsId);

                return $goods->stock >= $number;

            } else {

                $sku = current($skuList);

                return $sku['stock'] >= $number;
            }

        } else {

            $spec = GoodsSpecModel::where('goods_id', $goodsId)
                ->where('id', $skuId)
                ->first();

            return $spec->stock >= $number;
        }
    }


    /**
     * 扣减库存
     * @param $goodsId
     * @param $number
     * @param $skuId
     * @return mixed
     */
    public function reduceGoodsStock($goodsId, $number, $skuId = '')
    {
        $stock = $this->getGoodsStock($goodsId, $skuId);
        $reduce = min($stock, $number);

        return $skuId ?
            GoodsSpecModel::where('goods_id', $goodsId)->where('id', $skuId)->decrement('stock', $reduce) :
            Goods::where('id', $goodsId)->decrement('stock', $reduce);
    }

    /**
     * 生成订单号
     * @return string
     */
    public function makeOrderSn(): string
    {
        do {

            $orderSn = date('ymdHis') . mt_rand(10000, 99999);
            $order = Order::where('order_sn', $orderSn)->select(['id'])->first();

        } while ($order);

        return $orderSn;
    }


    /**
     * 获取商品 SKU
     * @param $goodsId
     * @param $key string spec_key id
     * @return array
     */
    public function goodsSkuList($goodsId, $key = ''): array
    {
        $array = [];
        $specs = GoodsSpecModel::where('goods_id', $goodsId)
            ->get()
            ->toArray();

        if ($specs) {

            foreach ($specs as $item) {

                if ($key) {

                    $array[$item[$key]] = $item;

                } else {

                    $array[] = $item;
                }
            }
        }

        return $array;
    }


    /**
     * 获取商品关联的规格
     * @param $id
     * @return array
     */
    public function goodsSpecList($id): array
    {
        return GoodsSpecItemModel::with('values')->where('goods_id', $id)->get()->toArray();
    }


    /**
     * 商品评论
     * @param $id
     * @param $page
     * @param $size
     * @return LengthAwarePaginator
     */
    public function goodsComments($id, $page = 1, $size = 10): LengthAwarePaginator
    {
        return GoodsCommentModel::with(['resource:comment_id,type,path'])
            ->where('goods_id', $id)
            ->paginate($size, '*', 'page', $page);
    }


    /**
     * 分类多语言内容
     * @param $id
     * @return array
     */
    public function categoryLang($id): array
    {
        $result = [];

        $metas = GoodsCategoryMeta::orderBy('id', 'desc')
            ->where('category_id', $id)
            ->whereIn('meta_key', array_map(function ($item) {
                return $item . "_goods_category";
            }, system_lang_meta()))->get()->toArray();

        foreach ($metas as $item) {

            $result[$item['meta_key']] = json_decode($item['meta_value'], true);
        }

        return $result;
    }

    /**
     * 商品多语言内容
     * @param $id
     * @return array
     */
    public function goodsLang($id): array
    {
        $result = [];
        $sysLang = system_tap_lang();

        $metas = GoodsMeta::orderBy('id', 'desc')
            ->where('goods_id', $id)
            ->whereIn('meta_key', array_map(function ($item) {
                return $item . "_goods";
            }, system_lang_meta()))->get()->toArray();

        foreach ($metas as $item) {

            [$string, $lang] = explode("_", $item['meta_key']);
            $result[$item['meta_key']] = array_merge(
                [
                    'lang_name' => $sysLang[$lang] ?? '',
                    'id' => $item['id']
                ],
                json_decode($item['meta_value'], true)
            );
        }

        return $result;
    }
}
