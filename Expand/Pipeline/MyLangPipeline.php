<?php

namespace Expand\Pipeline;


class MyLangPipeline
{
    public function commonHandle($content, $ident)
    {
        return $content->getModelLang($ident);
    }
}
