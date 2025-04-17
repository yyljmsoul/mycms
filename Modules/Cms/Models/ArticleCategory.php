<?php


namespace Modules\Cms\Models;


use App\Models\MyModel;

class ArticleCategory extends MyModel
{

    protected $table = 'my_article_category';

    public function __get($key)
    {
        $meta = ArticleCategoryMeta::where([
            'category_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? parent::langMeta($meta) : parent::__get($key);
    }

    /**
     * 返回树形数据
     * @return mixed
     */
    public static function toTree()
    {
        $category = self::orderBy('id', 'asc')->get();

        collect($category)->each(function ($item) use (&$result) {
            $result[$item['pid']][] = $item;
        });

        return $result;
    }

    public function parent()
    {
        return $this->hasOne('Modules\Cms\Models\ArticleCategory', 'id', 'pid');
    }


    /**
     * 获取文章数量
     * @return mixed
     */
    public function article_count()
    {
        $ids = [$this->id];
        collect(self::where('pid', $this->id)->get())->each(function ($item) use (&$ids) {
            $ids[] = $item->id;
        });

        return Article::whereIn('category_id', $ids)->where('status', 1)->count();
    }
}
