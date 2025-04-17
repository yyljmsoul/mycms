<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;

class ArticleGroupController extends MyAdminController
{
    public $view = 'admin.article_group.';

    public $model = 'Modules\Cms\Models\ArticleGroupModel';

    public $request = 'Modules\Cms\Http\Requests\ArticleGroupRequest';

    public $with = ['category'];

    public function _create()
    {
        $categories = app('cms')->categoryTreeForSelect();
        return ['categories' => $categories];
    }

    public function _edit(): array
    {
        $categories = app('cms')->categoryTreeForSelect();
        return ['categories' => $categories];
    }


    public function json()
    {
        $cid = $this->param('category_id');
        $result = $this->getModel()::where('category_id', $cid)->get()->toArray();

        return $this->success(['data' => $result]);
    }
}
