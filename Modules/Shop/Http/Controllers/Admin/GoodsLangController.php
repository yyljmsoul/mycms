<?php

namespace Modules\Shop\Http\Controllers\Admin;

use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Shop\Models\GoodsMeta;

class GoodsLangController extends MyController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $id = $this->param('id');
            $metas = app('store')->goodsLang($id);
            $paginate = new LengthAwarePaginator($metas, count($metas), 15);

            return $this->success($paginate->toArray());
        }

        return $this->view('admin.lang.index', ['goodsId' => $request->input('goods_id')]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $goodsId = $this->param('goods_id');

        $result = app('store')->goodsLang($goodsId);

        $notExistLang = array_diff(array_map(function ($item) {
            return str_replace(['lang_', '_goods'], '', $item);
        }, array_keys($result)), system_tap_lang());

        return $this->view('admin.lang.create', compact('notExistLang'));
    }

    /**
     * 保存
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $abb = $this->param('abb');
        $lang = $this->param('lang', '', []);
        $goodsId = $this->param('goods_id');

        if ($abb) {

            $result = GoodsMeta::insert([
                'goods_id' => $goodsId,
                'meta_key' => "lang_{$abb}_goods",
                'meta_value' => json_encode($lang)
            ]);

            return $this->result($result);
        }

        return $this->result(false, ['msg' => '请选择商品语言']);
    }

    /**
     * 编辑
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $id = $this->param('id');
        $meta = GoodsMeta::find($id);
        $goods = json_decode($meta->meta_value);
        return $this->view('admin.lang.edit', compact('goods'));
    }

    /**
     * 更新
     * @return \Illuminate\Http\JsonResponse
     */
    public function update()
    {
        $id = $this->param('id');
        $lang = $this->param('lang', '', []);

        $result = GoodsMeta::where('id', $id)->update([
            'meta_value' => json_encode($lang)
        ]);

        return $this->result($result);
    }

    /**
     * 删除
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $id = $this->param('id');
        $result = GoodsMeta::destroy($id);

        return $this->result($result);
    }
}
