<?php

namespace Addons\Ads\Service;

use App\Service\MyService;

class AdService extends MyService
{

    /**
     * HTML类型内容
     * @param $ad
     * @return mixed
     */
    public function htmlContent($ad)
    {
        return $ad->content;
    }


    /**
     * Javascript 类型内容
     * @param $ad
     * @return string
     */
    public function scriptContent($ad)
    {

        $ads = '<script src="' . route('admin.addon.ads.entrance.js') . '"></script>';
        $ads .= '<div class="adsbycms" data-ad-code="' . $ad->code . '"></div>';

        return $ads . $ad->content;
    }

    /**
     * 超链接类型数组
     * @param $ad
     * @return mixed
     */
    public function linkContent($ad)
    {
        return json_decode($ad->content, true);
    }


    /**
     * 图片广告数组
     * @param $ad
     * @return mixed
     */
    public function imageContent($ad)
    {
        return json_decode($ad->content, true);
    }

}
