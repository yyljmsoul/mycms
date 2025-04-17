<?php


namespace Modules\Shop\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\Shop\Http\Requests\CategoryRequest;
use Modules\Shop\Models\GoodsCategoryMeta;
use Modules\Shop\Models\GoodsCategory;

class CategoryController extends MyController
{


    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $category = GoodsCategory::with("parent:id,name")
                ->orderBy('id', 'desc')
                ->where($this->adminFilter($request->input('filter')))
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($category);
        }
        return $this->view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = app('store')->categoryTreeForSelect();
        return $this->view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request, GoodsCategory $category)
    {
        $data = $request->validated();
        $result = $category->store($data);

        if ($result) {

            $this->updateMeta($category->id);
            $this->updateLang($category->id);
        }

        return $this->result($result);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = $this->param('id', 'intval');
        $categories = app('store')->categoryTreeForSelect();
        $category = GoodsCategory::find($id);

        $meta = app('store')->categoryMeta($id, ['apply_to_category', 'apply_to_goods', 'sub_name']);
        $categoryLang = app('store')->categoryLang($id);

        return $this->view('admin.category.edit', compact('categories', 'category', 'meta', 'categoryLang'));
    }

    /**
     * 更新
     */
    public function update(CategoryRequest $request, GoodsCategory $category)
    {

        if ($id = $this->param('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;
            $result = $category->up($data);

            if ($result) {

                $this->updateMeta($id);
                $this->updateLang($id);
            }

            return $this->result($result);
        }

        return $this->result(false);
    }

    /**
     * 删除
     */
    public function destroy()
    {
        $result = GoodsCategory::destroy($this->param('id', 'intval'));
        return $this->result($result);
    }

    /**
     * 应用到商品的拓展
     */
    public function metaToGoods()
    {

        $meta = [];
        $result = false;

        if ($id = $this->param('id')) {

            $result = true;
            $metaArray = app('store')->categoryMeta($id, ['template', 'apply_to_category', 'title'])->toArray();

            if (!in_array('apply_to_goods', array_column($metaArray, 'meta_key'))) {
                $meta = [];
            } else {
                foreach ($metaArray as $item) {
                    if ($item['meta_key'] != 'apply_to_goods') {
                        $meta[] = $item;
                    }
                }
            }
        }

        return $this->result($result, ['data' => $meta]);
    }

    /**
     * 更新分类拓展
     * @param $id
     */
    protected function updateMeta($id)
    {

        $category = GoodsCategory::find($id);
        $attr = $this->param('attr');

        if ($applyCategory = $this->param('apply_to_category')) {
            $attr['ident'][] = 'apply_to_category';
            $attr['value'][] = $applyCategory;
        }

        if ($applyArticle = $this->param('apply_to_goods')) {
            $attr['ident'][] = 'apply_to_goods';
            $attr['value'][] = $applyArticle;
        }

        if ($category->pid > 0 && $category->parent->apply_to_category) {

            $parentMeta = app('store')->categoryMeta($category->pid, ['apply_to_category', 'apply_to_goods']);

            foreach ($parentMeta as $value) {

                if (!in_array($value->meta_key, $attr['ident'])) {

                    $attr['ident'][] = $value->meta_key;
                    $attr['value'][] = $value->meta_value;
                }
            }

        }

        GoodsCategoryMeta::where('category_id', $id)->delete();

        $meta = [];

        foreach ($attr['ident'] as $key => $ident) {

            if ($ident) {

                $meta[] = [
                    'category_id' => $id,
                    'meta_key' => $ident,
                    'meta_value' => $attr['value'][$key],
                ];

            }
        }

        GoodsCategoryMeta::insertAll($meta);
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
                'category_id' => $id,
                'meta_key' => "lang_{$abb}_goods_category",
                'meta_value' => json_encode($value),
            ];

            GoodsCategoryMeta::insert($meta);
        }
    }
}
