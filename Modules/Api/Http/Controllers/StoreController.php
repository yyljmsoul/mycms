<?php


namespace Modules\Api\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Modules\Shop\Http\Requests\CartStoreRequest;

class StoreController extends ApiController
{

    /**
     * 商城首页
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = [
            'config' => system_config([], 'shop'),
            'user' => [],
            'order' => []
        ];

        if ($uid = $this->getUserId()) {

            $result['user'] = app('user')->user($uid);
            $result['order'] = app('order')->orderCount($uid);
        }

        return $this->success(['result' => $result]);
    }

    /**
     * 分类列表
     * @return JsonResponse
     */
    public function categories(): JsonResponse
    {
        $categories = $this->collectFilterField(store_category() ?: [], [
            'updated_at'
        ], true);

        $level = max(array_column(read_tree_recursively($categories), 'level'));

        return $this->success(['result' => $categories, 'level' => $level]);
    }

    /**
     * 分类详情
     * @return JsonResponse
     */
    public function categoryInfo(): JsonResponse
    {
        $id = $this->param('id', 'intval');
        $category = app('store')->categoryInfo($id) ?: [];

        if ($category) {

            $category = $this->objectFilterField($category, ['updated_at'], true);
        }

        return $this->success(['result' => $category]);
    }

    /**
     * 商品列表
     * @return JsonResponse
     */
    public function goodsList(): JsonResponse
    {
        $page = $this->param('page', 'intval', 1);
        $limit = $this->param('limit', 'intval', 10);
        $tag = $this->param('tag', '', 'new');
        $params = request()->input('params', '[]');

        $result = [];
        $goods = goods($page, $limit, $tag, is_array($params) ? $params : json_decode($params, true)) ?: [];

        if ($goods) {

            $result = $this->pageFilterField($goods);
            $result['data'] = [];

            foreach ($goods as $item) {

                $result['data'][] = $this->objectFilterField($item, [
                    'content', 'updated_at', 'created_at'
                ], true);
            }
        }

        return $this->success(['result' => $result]);
    }

    /**
     * 商品详情
     * @return JsonResponse
     */
    public function goodsInfo(): JsonResponse
    {
        $id = $this->param('id', 'intval');

        $goods = app('store')->goods($id) ?: [];

        if ($goods) {

            $goods = $this->objectFilterField($goods, [], true);

            app('store')->goodsAddView($id);
        }

        return $this->success(['result' => $goods]);
    }


    /**
     * 购物车商品列表
     * @return JsonResponse
     */
    public function cart(): JsonResponse
    {
        $result = [];

        if ($uid = $this->getUserId()) {

            $goods = app('store')->cart($uid);

            if ($goods) {

                $result = $this->pageFilterField($goods);
                $result['data'] = [];

                foreach ($goods as $item) {

                    $data = $this->objectFilterField($item, [
                        'content', 'updated_at', 'created_at'
                    ], true);

                    if ($data['goods']) {

                        $data['goods']['goods_image'] = system_image_url($data['goods']['goods_image']);

                        $result['data'][] = $data;
                    }
                }
            }
        }

        return $this->success(['result' => $result]);
    }

    /**
     * 添加商品购物车
     * @param CartStoreRequest $request
     * @return JsonResponse
     */
    public function cartStore(CartStoreRequest $request): JsonResponse
    {
        $uid = $this->getUserId();
        $data = $request->validated();

        if (empty($uid)) {

            return $this->error(['msg' => "请登录后操作"]);
        }

        if (!app('store')->checkGoodsStock($data['goods_id'], $data['number'], $data['sku_id'] ?? 0)) {

            return $this->error(['msg' => "商品库存不足"]);
        }

        $result = app('store')->goodsToCart($uid, $data['goods_id'], $data['number'], $data['sku_id'] ?? 0, $data['direct'] ?? false);

        return $result ? $this->success([
            'result' => $result,
            'msg' => "已经添加到购物车"
        ]) : $this->error(['msg' => "添加到购物车失败"]);
    }

    /**
     * 热门搜索关键词
     * @return JsonResponse
     */
    public function hotKeywords(): JsonResponse
    {
        $keywords = [];

        if ($hotKeywordText = system_config('search_hot_keywords', 'shop')) {

            $keywords = explode("\n", $hotKeywordText);
        }

        return $this->success(['result' => $keywords]);
    }

    /**
     * 商品评论
     * @return JsonResponse
     */
    public function goodsComments(): JsonResponse
    {
        $id = $this->param('id', 'intval');

        $comments = app('store')->goodsComments($id) ?: [];

        return $this->success(['result' => $comments]);
    }

    /**
     * 购物车统计
     * @return JsonResponse
     */
    public function cartTotal(): JsonResponse
    {
        $uid = $this->getUserId();
        $ids = $this->param('ids');

        $result = app('store')->cartTotal($uid, $ids ? explode(",", $ids) : []);

        return $this->success(['result' => $result]);
    }

    /**
     * 删除购物车商品
     * @return JsonResponse
     */
    public function deleteCartGoods(): JsonResponse
    {
        $uid = $this->getUserId();
        $ids = $this->param('ids');

        $result = app('store')->deleteCartGoods($uid, $ids ? explode(",", $ids) : []);

        return $this->success(['msg' => $result ? '删除成功' : '删除失败']);
    }
}
