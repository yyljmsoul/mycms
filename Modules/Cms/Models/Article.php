<?php


namespace Modules\Cms\Models;


use App\Models\MyModel;

class Article extends MyModel
{

    protected $table = 'my_article';

    public function __get($key)
    {
        $meta = ArticleMeta::where([
            'article_id' => $this->getAttribute('id'),
            'meta_key' => $key
        ])->first();

        return $meta ? parent::langMeta($meta) : parent::__get($key);
    }

    public function category()
    {
        return $this->hasOne('Modules\Cms\Models\ArticleCategory', 'id', 'category_id');
    }


    /**
     * 返回上一篇
     * @return mixed
     */
    public function prev()
    {
        return $this->where('id', '<', $this->id)->where('category_id', $this->category_id)->where('status', 1)->orderBy('id', 'desc')->first();
    }

    /**
     * 返回下一篇
     * @return mixed
     */
    public function next()
    {
        return $this->where('id', '>', $this->id)->where('category_id', $this->category_id)->where('status', 1)->orderBy('id', 'asc')->first();
    }

}
