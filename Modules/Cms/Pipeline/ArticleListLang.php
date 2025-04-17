<?php

namespace Modules\Cms\Pipeline;

use Closure;
use Expand\Pipeline\MyLangPipeline;
use Expand\Pipeline\MyPipeline;

class ArticleListLang extends MyLangPipeline implements MyPipeline
{
    public function handle($content, Closure $next)
    {
        foreach ($content->items() as &$item) {

            $item = $this->commonHandle($item, 'single');
        }

        return $next($content);
    }
}
