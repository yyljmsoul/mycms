<?php


namespace Modules\Cms\Http\Controllers\Admin;


use App\Http\Controllers\MyController;
use Illuminate\Http\Request;
use Modules\Cms\Http\Requests\ArticleRequest;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleMeta;
use Modules\Cms\Models\ArticleTag;
use Modules\Cms\Models\ArticleTagRel;

class ArticleController extends MyController
{

    public function index(Request $request)
    {
        if ($request->ajax() && $request->wantsJson()) {

            $category = Article::with('category:id,name')->orderBy('id', 'desc')
                ->where($this->adminFilter($request->input('filter'), [
                    'title' => function ($value) {
                        return ['title', 'like', "%{$value}%"];
                    }, 'category.name' => function ($value) {
                        $category = ArticleCategory::where('name', $value)->first();
                        return ['category_id', '=', $category->id ?? 0];
                    }
                ]))
                ->paginate($this->param('limit', 'intval'))->toArray();

            return $this->success($category);
        }
        return $this->view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = app('cms')->categoryTreeForSelect();
        $attributes = app('system')->attributes('cms');

        return $this->view('admin.article.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request, Article $article, ArticleTag $tag, ArticleTagRel $tagRel)
    {
        $data = $request->validated();
        $result = $article->store($data);

        if ($result !== false) {

            if ($tags = request()->input('tags')) {

                $tagIds = $tag->insertTags(explode(",", $tags));
                $tagRel->insertRel($article->id, $tagIds);
            }

            if ($alias = $this->param('alias')) {

                url_format_alias_store($article->id, $alias, 'single');
            }

            $this->updateMeta($article->id);
            $this->updateLang($article->id);
        }

        return $this->result($result, ['id' => $article->id, 'title' => $article->title, 'url' => single_path($article->id), 'status' => $article->status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit()
    {
        $id = $this->param('id', 'intval');
        $categories = app('cms')->categoryTreeForSelect();

        $article = Article::find($id);
        $tags = article_tags_text($id);

        $attributes = app('system')->attributes('cms');
        $articleLang = app('cms')->articleLang($id);
        $meta = app('cms')->articleMeta($id,
            array_merge(
                ['short_title'],
                array_column($attributes, 'ident')
            )
        );

        return $this->view('admin.article.edit', compact('categories', 'article', 'tags', 'meta', 'attributes', 'articleLang'));
    }


    /**
     * 更新
     */
    public function update(ArticleRequest $request, Article $article, ArticleTag $tag, ArticleTagRel $tagRel)
    {

        if ($id = $this->param('id', 'intval')) {

            $data = $request->validated();
            $data['id'] = $id;

            $result = $article->up($data);

            if ($result !== false) {

                if ($tags = request()->input('tags')) {

                    $tagIds = $tag->insertTags(explode(",", $tags));
                    $tagRel->insertRel($id, $tagIds);
                }

                if ($alias = $this->param('alias')) {

                    url_format_alias_update($id, $alias, 'single');
                }

                $this->updateMeta($id);
                $this->updateLang($id);
            }

            return $this->result($result, ['id' => $id, 'url' => single_path($id), 'status' => $data['status']]);
        }

        return $this->result(false);
    }

    /**
     * 删除
     */
    public function destroy()
    {
        $id = $this->param('id', 'intval');

        $result = Article::destroy($id);

        if ($result) {

            url_format_alias_destroy('single', $id);
        }

        return $this->result($result);
    }


    /**
     * 标签信息
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function tags()
    {
        $id = $this->param('id', 'intval');
        $tags = article_tags_text($id);
        $article = Article::find($id);

        return $this->view('admin.article.tags', compact('article', 'tags'));
    }

    /**
     * 标签保存
     * @param ArticleTag $tag
     * @param ArticleTagRel $tagRel
     * @return \Illuminate\Http\JsonResponse
     */
    public function tagStore(ArticleTag $tag, ArticleTagRel $tagRel)
    {
        if ($id = $this->param('id', 'intval')) {
            $tags = request()->input('tags');
            $tagIds = $tag->insertTags(explode(",", $tags));
            $tagRel->insertRel($id, $tagIds);

            return $this->result($tagIds ?? false);
        }

        return $this->result(false);
    }

    /**
     * 更新拓展信息
     * @param $id
     * @return void
     */
    protected function updateMeta($id)
    {
        $attr = $this->param('attr');
        ArticleMeta::where('article_id', $id)->delete();

        foreach ($attr['ident'] as $key => $ident) {

            if ($ident && isset($attr['value'][$key])) {

                $meta = [
                    'article_id' => $id,
                    'meta_key' => $ident,
                    'meta_value' => $attr['value'][$key],
                ];

                (new ArticleMeta)->store($meta);
            }

        }
    }

    /**
     * 修改状态字段
     */
    public function modify()
    {
        $admin = Article::find($this->param('id', 'intval'));
        $admin->{$this->param('field')} = $this->param('value');
        $result = $admin->save();

        return $this->result($result);
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
                'article_id' => $id,
                'meta_key' => "lang_{$abb}_single",
                'meta_value' => json_encode($value),
            ];

            ArticleMeta::insert($meta);
        }
    }
}
