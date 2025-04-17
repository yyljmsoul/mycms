<?php


namespace Modules\System\Http\ViewComposer;


use Illuminate\View\View;

class TemplateComposer
{
    public function compose(View $view)
    {
        $data = [
            'authUser' => auth()->user()
        ];

        if ($route = request()->route()) {
            $data['page'] = $route->parameter('page');
        }

        $view->with($data);
    }
}
