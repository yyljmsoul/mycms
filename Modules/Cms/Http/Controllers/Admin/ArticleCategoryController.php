<?php


namespace Modules\Cms\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\Cms\Http\Requests\ArticleCategoryRequest;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleCategoryMeta;

class ArticleCategoryController extends MyController
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {
            $category = ArticleCategory::with('parent:id,name')
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
        $categories = app('cms')->categoryTreeForSelect();
        return $this->view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleCategoryRequest $request, ArticleCategory $category)
    {
        $data = $request->validated();

        $result = $category->store($data);

        if ($result !== false) {

            $this->updateMeta($category->id);
            $this->updateLang($category->id);

            $this->param('alias') && url_format_alias_store($category->id, $this->param('alias'), 'category');
        }

        return $this->result($result, ['title' => $data['name'], 'id' => $category->id]);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $id = $this->param('id', 'intval');

        $categories = app('cms')->categoryTreeForSelect();
        $category = ArticleCategory::find($id);

        $meta = app('cms')->categoryMeta($id, ['apply_to_category', 'apply_to_article', 'sub_name']);
        $categoryLang = app('cms')->categoryLang($id);

        return $this->view('admin.category.edit', compact('categories', 'category', 'meta', 'categoryLang'));
    }

    /**
     * 更新
     */
    public function update(ArticleCategoryRequest $request, ArticleCategory $category)
    {

        if ($id = $this->param('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;

            $result = $category->up($data);

            if ($result !== false) {

                $this->updateMeta($id);
                $this->updateLang($id);

                $this->param('alias') && url_format_alias_update($id, $this->param('alias'), 'category');
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
        $id = $this->param('id', 'intval');

        $result = ArticleCategory::destroy($id);

        if ($result) {

            url_format_alias_destroy('category', $id);
            ArticleCategoryMeta::where('category_id', $id)->delete();
        }

        return $this->result($result);
    }

    /**
     * 应用到文章的拓展
     */
    public function metaToArticle()
    {

        $meta = [];
        $result = false;

        if ($id = $this->param('id')) {

            $result = true;
            $metaArray = app('cms')->categoryMeta($id, ['template', 'apply_to_category', 'sub_name'])->toArray();

            if (!in_array('apply_to_article', array_column($metaArray, 'meta_key'))) {
                $meta = [];
            } else {
                foreach ($metaArray as $item) {
                    if ($item['meta_key'] != 'apply_to_article') {
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

        $category = ArticleCategory::find($id);
        $attr = $this->param('attr');

        if ($applyCategory = $this->param('apply_to_category')) {
            $attr['ident'][] = 'apply_to_category';
            $attr['value'][] = $applyCategory;
        }

        if ($applyArticle = $this->param('apply_to_article')) {
            $attr['ident'][] = 'apply_to_article';
            $attr['value'][] = $applyArticle;
        }

        if ($category->pid > 0 && $category->parent->apply_to_category) {

            $parentMeta = app('cms')->categoryMeta($category->pid, ['apply_to_category', 'apply_to_article']);

            foreach ($parentMeta as $value) {

                if (!in_array($value->meta_key, $attr['ident'])) {

                    $attr['ident'][] = $value->meta_key;
                    $attr['value'][] = $value->meta_value;
                }
            }

        }

        ArticleCategoryMeta::where('category_id', $id)->delete();

        foreach ($attr['ident'] as $key => $ident) {

            if ($ident) {

                $meta = [
                    'category_id' => $id,
                    'meta_key' => $ident,
                    'meta_value' => $attr['value'][$key],
                ];

                (new ArticleCategoryMeta)->store($meta);
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

        if ($lang) {
            foreach ($lang as $abb => $value) {

                $meta = [
                    'category_id' => $id,
                    'meta_key' => "lang_{$abb}_category",
                    'meta_value' => json_encode($value),
                ];

                ArticleCategoryMeta::insert($meta);
            }
        }

    }
}
