<?php

namespace Modules\Cms\Pipeline;

use Closure;
use Expand\Pipeline\MyLangPipeline;
use Expand\Pipeline\MyPipeline;

class CategoryLang extends MyLangPipeline implements MyPipeline
{
    public function handle($content, Closure $next)
    {
        $content = $this->commonHandle($content, 'category');

        return $next($content);
    }
}
