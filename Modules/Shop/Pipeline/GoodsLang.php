<?php

namespace Modules\Shop\Pipeline;

use Closure;
use Expand\Pipeline\MyLangPipeline;
use Expand\Pipeline\MyPipeline;

class GoodsLang extends MyLangPipeline implements MyPipeline
{
    public function handle($content, Closure $next)
    {
        $content = $this->commonHandle($content, 'goods');

        return $next($content);
    }
}
