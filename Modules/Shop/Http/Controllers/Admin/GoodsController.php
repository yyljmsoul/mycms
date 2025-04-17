<?php


namespace Modules\Shop\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Shop\Http\Requests\GoodsRequest;
use Modules\Shop\Models\Goods;
use Modules\Shop\Models\GoodsAlbums;
use Modules\Shop\Models\GoodsCategory;
use Modules\Shop\Models\GoodsMeta;
use Modules\Shop\Models\GoodsMobileImagesModel;
use Modules\Shop\Models\GoodsSpecItemModel;
use Modules\Shop\Models\GoodsSpecModel;
use Modules\Shop\Models\GoodsSpecValueModel;

class GoodsController extends MyController
{

    protected $spec = [];

    protected $specText = [];

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $goods = Goods::with('category:id,name')->orderBy('id', 'desc')
                ->where($this->adminFilter($request->input('filter'),
                    [
                        'goods_name' => function ($value) {
                            return ['goods_name', 'like', "%{$value}%"];
                        },
                        'category.name' => function ($value) {
                            $category = GoodsCategory::where('name', $value)->first();
                            return ['category_id', '=', $category->id ?? 0];
                        }
                    ]))
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($goods);
        }
        return $this->view('admin.goods.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = app('store')->categoryTreeForSelect();
        $attributes = app('system')->attributes('shop');

        return $this->view('admin.goods.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoodsRequest $request, Goods $goods)
    {
        $data = $request->validated();

        DB::beginTransaction();

        $result = $goods->store($data);

        if ($result) {

            $this->goodsAction($goods->id);
        }

        DB::commit();

        return $this->result($result);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = $this->param('id', 'intval');
        $categories = app('store')->categoryTreeForSelect();

        $goods = Goods::find($id);
        $goods && $goods->goods_albums = app('store')->goodsAlbums($id);

        $attributes = app('system')->attributes('shop');

        $meta = app('store')->goodsMeta($id,
            array_merge(
                ['short_title'],
                array_column($attributes, 'ident')
            )
        );

        $specItems = app('store')->goodsSpecList($id);

        $specArray = app('store')->goodsSkuList($id, 'spec_name');

        $mobileImages = app('store')->goodsMobileImages($id);

        return $this->view('admin.goods.edit',
            compact(
                'categories',
                'goods',
                'attributes',
                'meta',
                'specItems',
                'specArray',
                'mobileImages',
            )
        );
    }

    /**
     * 更新
     * @throws \Exception
     */
    public function update(GoodsRequest $request, Goods $goods): \Illuminate\Http\JsonResponse
    {

        if ($id = $this->param('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;

            DB::beginTransaction();

            $result = $goods->up($data);

            if ($result) {

                $this->goodsAction($id);
            }

            DB::commit();

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除
     */
    public function destroy(): \Illuminate\Http\JsonResponse
    {
        app('goods')->destroyGoods($this->param('id', 'intval'));
        return $this->result();
    }

    /**
     * 商品拓展操作
     * @param $id
     * @return void
     * @throws \Exception
     */
    protected function goodsAction($id)
    {
        $this->updateMeta($id);
        $this->updateLang($id);
        $this->updateAlbums($id);
        $this->updateSpec($id);
        $this->updateMobileImages($id);
    }

    /**
     * 更新拓展信息
     * @param $id
     */
    protected function updateMeta($id)
    {
        $attr = $this->param('attr');
        GoodsMeta::where('goods_id', $id)->delete();

        foreach ($attr['ident'] as $key => $ident) {

            if ($ident && isset($attr['value'][$key])) {

                $meta = [
                    'goods_id' => $id,
                    'meta_key' => $ident,
                    'meta_value' => $attr['value'][$key],
                ];

                GoodsMeta::insert($meta);
            }

        }
    }


    /**
     * 更新商品相册
     * @param $id
     */
    protected function updateAlbums($id)
    {
        $albums = $this->param('goods_albums');
        GoodsAlbums::where('goods_id', $id)->delete();

        if ($albums) {

            $data = [];

            foreach ($albums as $album) {

                if ($album) {

                    $data[] = [
                        'goods_id' => $id,
                        'goods_image' => $album,
                    ];
                }
            }

            $data && GoodsAlbums::insertAll($data);
        }

    }


    /**
     * 更新商品手机端详情
     * @param $id
     * @return void
     */
    protected function updateMobileImages($id)
    {
        $images = $this->param('mobile_images');

        GoodsMobileImagesModel::where('goods_id', $id)->delete();

        if ($images) {

            $data = [];

            foreach ($images as $image) {

                if ($image) {

                    $data[] = [
                        'goods_id' => $id,
                        'path' => $image,
                    ];
                }
            }

            $data && GoodsMobileImagesModel::insertAll($data);
        }
    }


    /**
     * 更新规格
     * @param $id
     * @return void
     * @throws \Exception
     */
    protected function updateSpec($id)
    {
        try {

            $items = [];
            $specItemArray = [];
            $specValueArray = [];
            $specTextArray = [];
            $date = date('Y-m-d H:i:s');

            $specItem = $this->param('spec', '', []);
            $specValue = $this->param('specVal');
            $img = $this->param('spec_img');
            $specIds = $this->param('specIds');
            $specValIds = $this->param('specValIds');
            $stock = $this->param('spec_stock');
            $shop_price = $this->param('spec_shop_price');
            $market_price = $this->param('spec_market_price');
            $specItemNames = '';

            //GoodsSpecItemModel::where('goods_id', $id)->delete();
            //GoodsSpecValueModel::where('goods_id', $id)->delete();
            //GoodsSpecModel::where('goods_id', $id)->delete();

            foreach ($specItem as $key => $item) {

                if (empty($item) || empty($specValue[$key])) {

                    continue;
                }

                $values = $specValue[$key];
                $condition = [
                    ['goods_id', '=', $id],
                    ['id', '=', $key],
                ];

                $gsi = GoodsSpecItemModel::where($condition)->first();

                if ($gsi) {

                    $specItemArray[] = $itemId = $key;

                    GoodsSpecItemModel::where($condition)->update([
                        'name' => $item,
                        'values' => json_encode($values),
                    ]);

                } else {

                    $specItemArray[] = $itemId = GoodsSpecItemModel::insert([
                        'goods_id' => $id,
                        'spec_id' => $specIds[$key],
                        'name' => $item,
                        'values' => json_encode($values),
                    ]);
                }


                $specItemNames .= $item . ';';

                $specValueArray[$itemId] = [];

                $valId = 0;

                foreach ($values as $kv => $val) {

                    if (empty($val)) {

                        continue;
                    }

                    $data = [
                        'goods_id' => $id,
                        'spec_id' => $itemId,
                        'spec_val_id' => $specValIds[$key][$kv],
                        'value' => $val,
                    ];

                    $condition = [
                        ['goods_id', '=', $id],
                        ['spec_id', '=', $itemId],
                        ['id', '=', $kv],
                    ];

                    $value = GoodsSpecValueModel::where($condition)->first();

                    if ($value && $valId != $kv) {

                        $valId = $value->id;

                        GoodsSpecValueModel::where($condition)->update($data);

                    } else {

                        $valId = GoodsSpecValueModel::insert($data);
                    }

                    $specTextArray[$itemId][] = $val;
                    $specValueArray[$itemId][] = $valId;
                }
            }

            $this->specArray($specItemArray, $specValueArray);
            $this->specTextArray($specItemArray, $specTextArray);

            $specArray = app('store')->goodsSkuList($id, 'spec_name');

            foreach ($this->spec as $key => $spec) {

                $data = [
                    'goods_id' => $id,
                    'spec_name' => $this->specText[$key],
                    'spec_item_name' => trim($specItemNames, ';'),
                    'spec_key' => $spec,
                    'stock' => $stock[$key],
                    'img' => $img[$key],
                    'market_price' => $market_price[$key],
                    'shop_price' => $shop_price[$key],
                ];

                if (!empty($specArray[$this->specText[$key]])) {

                    GoodsSpecModel::where('id', $specArray[$this->specText[$key]]['id'])->update($data);

                } else {

                    $data['created_at'] = $date;
                    $data['updated_at'] = $date;

                    $items[] = $data;
                }

            }

            if ($items) {

                GoodsSpecModel::insertAll($items);
            }

        } catch (\Exception $exception) {

            DB::rollBack();

            throw new \Exception('请完整填写商品规格');
        }

    }


    /**
     * 处理商品规格数据
     * @param $specItemArray
     * @param $specValueArray
     * @param int $index
     * @param string $subContext
     * @return void
     */
    protected function specArray($specItemArray, $specValueArray, int $index = 0, string $subContext = '')
    {
        if (isset($specItemArray[$index])) {

            $itemId = $specItemArray[$index];
            $array = $specValueArray[$itemId];

            foreach ($array as $item) {

                $item = $itemId . ":" . $item;

                if ($index !== 0) {
                    $item = $subContext . ';' . $item;
                }

                if (count($specValueArray) === 1) {
                    $this->spec[] = $item;
                } else {
                    if ($index === count($specValueArray) - 1 && $index !== 0) {
                        $this->spec[] = $item;
                    } else {
                        $this->specArray($specItemArray, $specValueArray, $index + 1, $item);
                    }
                }

            }
        }

    }


    /**
     * 处理商品规格数据
     * @param $specItemArray
     * @param $specTextArray
     * @param int $index
     * @param string $subContext
     * @return void
     */
    protected function specTextArray($specItemArray, $specTextArray, int $index = 0, string $subContext = '')
    {
        if (isset($specItemArray[$index])) {
            $itemId = $specItemArray[$index];
            $array = $specTextArray[$itemId];

            foreach ($array as $item) {

                if ($index !== 0) {
                    $item = $subContext . ';' . $item;
                }

                if (count($specTextArray) === 1) {
                    $this->specText[] = $item;
                } else {
                    if ($index === count($specTextArray) - 1 && $index !== 0) {
                        $this->specText[] = $item;
                    } else {
                        $this->specTextArray($specItemArray, $specTextArray, $index + 1, $item);
                    }
                }

            }
        }
    }


    /**
     * 多语言版本更新
     * @param $id
     * @return void
     */
    protected function updateLang($id)
    {
        $lang = $this->param('lang', '', []);

        foreach ($lang as $abb => $value) {

            $meta = [
                'goods_id' => $id,
                'meta_key' => "lang_{$abb}_goods",
                'meta_value' => json_encode($value),
            ];

            GoodsMeta::insert($meta);
        }
    }

}
