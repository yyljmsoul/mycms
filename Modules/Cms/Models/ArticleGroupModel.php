<?php

namespace Modules\Cms\Models;

use App\Models\MyModel;

class ArticleGroupModel extends MyModel
{
    protected $table = 'my_article_group';

    public function category()
    {
        return $this->hasOne('Modules\Cms\Models\ArticleCategory', 'id', 'category_id');
    }
}
