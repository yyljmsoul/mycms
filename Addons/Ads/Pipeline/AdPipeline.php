<?php


namespace Addons\Ads\Pipeline;


use Addons\Ads\Models\Ads;
use Closure;
use Expand\Pipeline\MyPipeline;

class AdPipeline implements MyPipeline
{

    public function handle($content, Closure $next)
    {
        $info = Ads::where('code', $content)->first();

        if ($info) {

            $data = $info->content;

            if (method_exists(app('ads'), $info->type . "Content")) {

                $data = app('ads')->{$info->type . "Content"}($info);
            }

            return $next($data);
        }

        return $next(null);
    }
}
