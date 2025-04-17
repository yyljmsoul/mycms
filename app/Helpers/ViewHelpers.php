<?php


namespace App\Helpers;


use Illuminate\Support\Str;

trait ViewHelpers
{

    /**
     * 模板
     */
    public function theme($view = null, $data = [], $mergeData = [])
    {
        $theme = system_config('cms_theme') ?: 'default';
        return view("template::{$theme}.views." . $view, $data, $mergeData);
    }

    /**
     * 视图
     */
    public function view($view = null, $data = [], $mergeData = [])
    {
        $viewType = $this->expandType();

        $view = $viewType['name'] . ($viewType['type'] == 'addons' ? "::" : ".") . $view;

        $view = view($view, $data, $mergeData);

        if ($element = request()->input('_pjax')) {

            include_once base_path('Expand/phpQuery/phpQuery.php');
            \phpQuery::newDocumentHTML(response($view)->getContent());
            $view = pq($element)->html();
            $view .= pq('#extend-javascript')->html();
        }

        return $view;
    }

    /**
     * 获取拓展类型及名称
     */
    public function expandType(): array
    {
        $namespace = (new \ReflectionClass($this))->getNamespaceName();
        list($type, $name) = explode("\\", $namespace);

        return [
            'type' => strtolower(Str::snake($type)),
            'name' => strtolower(Str::snake($name))
        ];
    }

    /**
     * 获取CMS分类模板
     */
    public function cmsCategoryTemplate($category)
    {
        return $category->template ?: 'category';
    }


    /**
     * 获取CMS文章模板
     */
    public function cmsArticleTemplate($article)
    {
        if ($article->template) {
            return $article->template;
        }

        if ($article->category->single_template) {
            return $article->category->single_template;
        }

        return 'single';
    }
}
