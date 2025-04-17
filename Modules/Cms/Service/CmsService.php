<?php


namespace Modules\Cms\Service;


use App\Service\MyService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Cms\Models\Article;
use Modules\Cms\Models\ArticleCategory;
use Modules\Cms\Models\ArticleCategoryMeta;
use Modules\Cms\Models\ArticleComment;
use Modules\Cms\Models\ArticleGroupModel;
use Modules\Cms\Models\ArticleMeta;
use Modules\Cms\Models\ArticleTag;
use Modules\Cms\Models\ArticleTagRel;

class CmsService extends MyService
{


    /**
     * 分类信息
     * @param $id
     * @return mixed
     */
    public function category($id)
    {
        $category = ArticleCategory::find($id);

        return pipeline_func($category, "category");
    }


    /**
     * 根据排序获取文章
     */
    public function articlesForSort($page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc')
    {
        $articleList = Article::with('category:id,name')
            ->status()
            ->orderBy($orderBy, $sort)
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($articleList, "article_list");
    }

    /**
     * 分类树形结构数据
     * @param int $pid
     * @return array
     */
    public function categoryTree(int $pid = 0): array
    {
        $data = ArticleCategory::toTree();
        return $this->tree($data, $pid);
    }

    /**
     * 分类详情
     * @param $id
     * @return mixed
     */
    public function categoryInfo($id)
    {
        return ArticleCategory::find($id);
    }

    /**
     * 分类树形结构数据（用于下拉框）
     * @return array
     */
    public function categoryTreeForSelect(): array
    {
        $data = ArticleCategory::toTree();
        return $this->treeForSelect($data);
    }

    /**
     * 子分类ID
     * @return array|int[]
     */
    public function categoryChildIds($pid = 0): array
    {
        $data = ArticleCategory::toTree();
        return $this->childIds($data, $pid, true);
    }

    /**
     * 根据ID获取文章详情
     * @param $id
     * @param false $meta
     * @return mixed
     */
    public function article($id, $meta = false)
    {
        $article = Article::with("category:id,name,single_template")->status()->find($id);

        if ($article && $meta) {

            $article->meta = ArticleMeta::where('article_id', $id)->get();
        }

        return pipeline_func($article, "article");
    }

    /**
     * 获取分类文章
     * @param $categoryId
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @param string $sort
     * @return LengthAwarePaginator
     */
    public function articleForCategory($categoryId, $page = 1, $limit = 10, $orderBy = 'id', $sort = 'desc'): LengthAwarePaginator
    {
        $childIds = $this->categoryChildIds($categoryId);

        $articleList = Article::with('category:id,name')
            ->status()
            ->orderBy($orderBy, $sort)
            ->whereIn('category_id', $childIds)
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($articleList, "article_list");
    }


    /**
     * 获取分类分组文章
     * @param $categoryId
     * @param $groupId
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @return LengthAwarePaginator
     */
    public function articleForGroup($categoryId, $groupId, $page = 1, $limit = 10, $orderBy = 'id'): LengthAwarePaginator
    {
        $childIds = $this->categoryChildIds($categoryId);

        $articleList = Article::with('category:id,name')
            ->status()
            ->orderBy($orderBy, 'desc')
            ->whereIn('category_id', $childIds)
            ->where('group_id', $groupId)
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($articleList, "article_list");
    }


    /**
     * 根据标签获取文章
     * @param $tagId
     * @param $page
     * @param $limit
     * @return false|LengthAwarePaginator
     */
    public function articleForTag($tagId, $page = 1, $limit = 10)
    {
        $articleIds = $this->articleIdForTag($tagId);

        if ($articleIds) {

            $articleList = Article::with("category:id,name")
                ->status()
                ->whereIn('id', $articleIds)
                ->orderBy('id', 'desc')
                ->paginate($limit, '*', 'page', $page);

            return pipeline_func($articleList, "article_list");
        }

        return false;
    }

    /**
     * 根据标签获取文章ID
     * @param $tagId
     * @return array|false
     */
    public function articleIdForTag($tagId)
    {
        $result = ArticleTagRel::where('tag_id', $tagId)
            ->select('article_id')->get()
            ->toArray();

        return $result ? array_column($result, 'article_id') : false;
    }

    /**
     * @param $keyword
     * @param $page
     * @param $limit
     * @param $orderBy
     * @return LengthAwarePaginator
     */
    public function articleForSearch($keyword, $page = 1, $limit = 10, $orderBy = 'id'): LengthAwarePaginator
    {
        $articleList = Article::with("category:id,name")
            ->status()
            ->orderBy($orderBy, 'desc')
            ->where('title', 'like', '%' . $keyword . '%')
            ->paginate($limit, '*', 'page', $page);

        return pipeline_func($articleList, "article_list");
    }

    /**
     * @param $attr
     * @param int $page
     * @param int $limit
     * @param string $orderBy
     * @return array|LengthAwarePaginator
     */
    public function articleForAttr($attr, $page = 1, $limit = 10, $orderBy = 'id')
    {
        $metas = ArticleMeta::where('meta_key', $attr)
            ->orderBy('article_id', 'desc')
            ->select(['article_id'])
            ->get()->toArray();

        if ($metas) {

            $articleId = array_column($metas, 'article_id');

            $articleList = Article::with("category:id,name")
                ->status()
                ->orderBy($orderBy, 'desc')
                ->whereIn('id', $articleId)
                ->paginate($limit, '*', 'page', $page);

            return pipeline_func($articleList, "article_list");
        }

        return [];

    }

    /**
     * 根据标签获取文章ID
     * @param $articleId
     * @return array|false
     */
    public function tagIdForArticle($articleId)
    {
        $result = ArticleTagRel::where('article_id', $articleId)
            ->select('tag_id')->get()
            ->toArray();

        return $result ? array_column($result, 'tag_id') : false;
    }

    /**
     * 文章标签
     * @param $articleId
     * @return array|LengthAwarePaginator
     */
    public function tagForArticle($articleId)
    {
        if (current_lang()) {

            $article = $this->article($articleId);

            if ($article->tags) {

                return ArticleTag::whereIn('tag_name', explode(",", $article->tags))->get()->toArray();
            }

        } else {

            if ($tags = $this->tagIdForArticle($articleId)) {

                return ArticleTag::whereIn('id', $tags)->get()->toArray();
            }
        }

        return [];
    }


    /**
     * 文章分组
     * @param $cid
     * @return mixed
     */
    public function articleGroup($cid)
    {
        return ArticleGroupModel::where('category_id', $cid)->orderBy('sort', 'desc')->get();
    }


    /**
     * 标签
     * @param $limit
     * @return mixed
     */
    public function tags($limit = 10)
    {
        return ArticleTag::limit($limit)->get();
    }


    /**
     * 标签
     * @param $limit
     * @return mixed
     */
    public function rec_tags($limit = 10)
    {
        $rel = ArticleTagRel::select([DB::raw('count(*) as count, tag_id')])->groupBy('tag_id')
            ->orderBy('count', 'desc')->limit($limit)->get()->toArray();
        return ArticleTag::whereIn('id', array_column($rel, 'tag_id'))->get();
    }

    /**
     * 文章评论列表
     * @param $articleId
     * @param $rootId
     * @param $page
     * @param $limit
     * @return LengthAwarePaginator
     */
    public function commentForArticle($articleId, $rootId, $page = 1, $limit = 10): LengthAwarePaginator
    {
        return ArticleComment::with('user:id,name,img')
            ->where([
                ['single_id', '=', $articleId],
                ['status', '=', 1],
                ['root_id', '=', $rootId],
            ])
            ->orderBy('id', $rootId == 0 ? 'desc' : 'asc')
            ->paginate($limit, '*', 'page', $page);
    }

    /**
     * 获取分类拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function categoryMeta($id, $exclude = [])
    {
        $meta = ArticleCategoryMeta::where('category_id', $id);

        $exclude = array_merge($exclude, array_map(function ($item) {
            return $item . "_category";
        }, system_lang_meta()));
        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 分类多语言内容
     * @param $id
     * @return array
     */
    public function categoryLang($id): array
    {
        $result = [];

        $metas = ArticleCategoryMeta::orderBy('id', 'desc')
            ->where('category_id', $id)
            ->whereIn('meta_key', array_map(function ($item) {
                return $item . "_category";
            }, system_lang_meta()))->get()->toArray();

        foreach ($metas as $item) {

            $result[$item['meta_key']] = json_decode($item['meta_value'], true);
        }

        return $result;
    }

    /**
     * 获取文章拓展
     * @param $id
     * @param array $exclude
     * @return mixed
     */
    public function articleMeta($id, $exclude = [])
    {
        $meta = ArticleMeta::where('article_id', $id);

        $exclude = array_merge($exclude, array_map(function ($item) {
            return $item . "_single";
        }, system_lang_meta()));
        $meta = $exclude ? $meta->whereNotIn('meta_key', $exclude) : $meta;

        return $meta->get();
    }

    /**
     * 文章多语言内容
     * @param $id
     * @return array
     */
    public function articleLang($id): array
    {
        $result = [];

        $metas = ArticleMeta::orderBy('id', 'desc')
            ->where('article_id', $id)
            ->whereIn('meta_key', array_map(function ($item) {
                return $item . "_single";
            }, system_lang_meta()))->get()->toArray();

        foreach ($metas as $item) {

            $result[$item['meta_key']] = json_decode($item['meta_value'], true);
        }

        return $result;
    }

    /**
     * 文章增加浏览数
     * @param $id
     * @return void
     */
    public function articleAddView($id)
    {
        Article::where('id', $id)->update([
            'view' => DB::raw('view + 1'),
        ]);
    }
}
