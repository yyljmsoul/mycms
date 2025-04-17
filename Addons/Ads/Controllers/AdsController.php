<?php


namespace Addons\Ads\Controllers;


use Addons\Ads\Models\Ads;
use App\Http\Controllers\MyAdminController;
use Illuminate\Support\Facades\Storage;

class AdsController extends MyAdminController
{

    public $model = 'Addons\Ads\Models\Ads';

    public $request = 'Addons\Ads\Requests\AdsRequest';

    /**
     * @param $id
     * @return mixed
     */
    public function afterStore($id)
    {
        $this->updateContent($id);
    }


    /**
     * 更新后操作
     * @param $id
     * @return mixed
     */
    public function afterUpdate($id)
    {
        return $this->updateContent($id);
    }

    /**
     * 更新广告内容
     * @param $id
     * @return mixed
     */
    protected function updateContent($id)
    {
        $content = $this->getAdContent();

        return Ads::where('id', $id)->update(['content' => $content]);
    }

    /**
     * 获取广告内容
     * @return array|mixed|string|string[]|null
     */
    protected function getAdContent()
    {
        $type = $this->param('type');

        $content = $this->param($type);

        if (method_exists($this, "{$type}Content")) {

            $content = $this->{"{$type}Content"}($content);
        }

        return $content;
    }

    /**
     * 处理图片广告内容
     * @param $content
     * @return false|string
     */
    protected function imageContent($content)
    {
        $items = [];

        foreach ($content['path'] ?? [] as $key => $path) {

            $items[] = [
                'path' => $path,
                'url' => $content['url'][$key],
            ];
        }

        return json_encode($items);
    }

    /**
     * 处理文字链接广告内容
     * @param $content
     * @return false|string
     */
    protected function linkContent($content)
    {
        $items = [];

        foreach ($content['text'] ?? [] as $key => $text) {

            $items[] = [
                'text' => $text,
                'url' => $content['url'][$key],
            ];
        }

        return json_encode($items);
    }

    /**
     * 预览
     */
    public function review()
    {
        $ad = Ads::find($this->param('id', 'intval'));

        return $this->view('admin.review', compact('ad'));
    }

    /**
     * 配置
     */
    public function config()
    {
        $config = system_config([], 'ad');
        return $this->view('admin.config', compact('config'));
    }

    /**
     * 保存配置
     */
    public function storeCfg()
    {
        $data = [
            'entrance_js' => $this->param('entrance_js'),
            'content_js' => $this->param('content_js'),
            'content_path' => $this->param('content_path'),
        ];

        $result = system_config_store($data, 'ad');

        $route = "<?php";
        $route .= "\nRoute::group(['namespace' => 'Addons\Ads\Controllers'], function () {";
        $route .= "\n\tRoute::get('/{$data['entrance_js']}', 'AdResourceController@entranceScript')->name('admin.addon.ads.entrance.js');";
        $route .= "\n\tRoute::get('/{$data['content_js']}', 'AdResourceController@contentScript')->name('admin.addon.ads.content.js');";
        $route .= "\n\tRoute::get('/{$data['content_path']}', 'AdResourceController@content')->name('admin.addon.ads.content');";
        $route .= "\n});\n?>";

        Storage::disk("root")->put("/Addons/Ads/Routes/forbid.php", $route);

        return $this->result($result);
    }

}
