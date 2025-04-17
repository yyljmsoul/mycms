<?php

namespace Modules\Shop\Pipeline;

use Closure;
use Expand\Pipeline\MyLangPipeline;
use Expand\Pipeline\MyPipeline;

class GoodsListLang extends MyLangPipeline implements MyPipeline
{
    public function handle($content, Closure $next)
    {
        foreach ($content->items() as &$item) {

            $item = $this->commonHandle($item, 'goods');
        }

        return $next($content);
    }
}
