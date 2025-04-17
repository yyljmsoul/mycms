<?php

namespace Modules\Mp\Http\Controllers\Admin;


class MpArticleController extends MpController
{
    public $view = 'admin.mp_article.';

    public $model = 'Modules\Mp\Models\MpArticleModel';

    public $request = 'Modules\Mp\Http\Requests\MpArticleRequest';

    public function preview()
    {
        $data = $this->getModel()::with($this->editWith)
            ->find($this->param('id', 'intval'));

        return $this->view($this->view . 'preview', compact('data'));
    }
}
