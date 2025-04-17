<?php

namespace Modules\Mp\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Exceptions\RuntimeException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Mp\Models\MpAccountModel;
use Modules\Mp\Models\MpArticleModel;
use QL\QueryList;

class MpPushLogController extends MyAdminController
{

    /**
     * @var \EasyWeChat\OfficialAccount\Application
     */
    protected $mpApp;

    public $view = 'admin.mp_push_log.';

    public $model = 'Modules\Mp\Models\MpPushLogModel';

    public $request = 'Modules\Mp\Http\Requests\MpPushLogRequest';

    public $with = ['account'];

    /**
     * 预览页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function preview()
    {
        $id = $this->param('id');
        return $this->view($this->view . ".preview", compact('id'));
    }

    /**
     * 发送预览请求
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendPreview(): \Illuminate\Http\JsonResponse
    {
        $id = $this->param('id');
        $wx = $this->param('wx');

        $data = $this->getModel()->find($id);
        $account = MpAccountModel::where('app_id', $data->appid)->first();

        if ($wx && $data->media_id) {

            $mpApp = Factory::officialAccount([
                'app_id' => $data->appid,
                'secret' => $account->app_key,
                'response_type' => 'array',
            ]);

            $result = $mpApp->broadcasting->previewNewsByName($data->media_id, $wx);

            return $result['errcode'] == 0
                ? $this->success(['msg' => '预览发送成功'])
                : $this->error(['msg' => '预览发送失败，' . $result['errmsg']]);
        }

        return $this->error(['msg' => empty($wx) ? '请填写预览微信号' : '该素材尚未上传，请重新保存上传']);
    }

    /**
     * 推送页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function pushShow()
    {
        $id = $this->param('id');
        return $this->view($this->view . ".push", compact('id'));
    }


    /**
     * @throws InvalidConfigException
     * @throws RuntimeException
     */
    public function push(): \Illuminate\Http\JsonResponse
    {
        $openid = $this->param('openid');
        $id = $this->param('id');

        $data = $this->getModel()->find($id);
        $account = MpAccountModel::where('app_id', $data->appid)->first();

        if ($data->media_id) {

            $mpApp = Factory::officialAccount([
                'app_id' => $data->appid,
                'secret' => $account->app_key,
                'response_type' => 'array',
            ])->broadcasting;

            $result = $openid
                ? $mpApp->sendNews($data->media_id, explode("\n", $openid))
                : $mpApp->sendNews($data->media_id);

            if ($result['errcode'] == 0) {
                $data->msg_id = $result['msg_id'];
                $data->save();
            }

            return $result['errcode'] == 0
                ? $this->success(['msg' => '请求发送成功，请耐心等候'])
                : $this->error(['msg' => '请求发送失败，' . $result['errmsg']]);

        }

        return $this->error(['msg' => '该素材尚未上传，请重新保存上传后操作']);

    }


    /**
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function afterStore($id): bool
    {
        return $this->uploadNews($id);
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function afterUpdate($id): bool
    {
        return $this->uploadNews($id);
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    protected function uploadNews($id): bool
    {
        $medias = [];
        $data = $this->getModel()->find($id);
        $account = MpAccountModel::where('app_id', $data->appid)->first();

        $this->mpApp = Factory::officialAccount([
            'app_id' => $data->appid,
            'secret' => $account->app_key,
            'response_type' => 'array',
        ]);

        $articles = MpArticleModel::whereIn('id', explode(",", $data->article_id))->get();

        foreach ($articles as $article) {

            $article->content = $this->replaceImage($article->content);
            $article->save();

            $medias[] = [
                'title' => $article->title,
                'thumb_media_id' => $this->uploadImage($article->thumb, 'media_id'), // 封面图片 mediaId
                'author' => $article->author, // 作者
                'show_cover' => 1, // 是否在文章内容显示封面图片
                'digest' => $article->digest,
                'content' => $article->content,
                'source_url' => $article->source_url,
            ];
        }

        $result = $this->mpApp->material->uploadArticle($medias);

        if ($result['media_id']) {
            $data->media_id = $result['media_id'];
            return $data->save();
        }

        return false;
    }

    /**
     * 上传图片到素材库
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function uploadImage($image, $field = 'url')
    {
        $date = date('Ymd');
        $siteUrl = system_config('site_url');

        if (strstr($image, $siteUrl) !== false) {
            $path = public_path(str_replace($siteUrl, "", $image));
        } else {
            $file = '/public/media/' . $date . '/' . Str::random(40) . ".png";
            Storage::disk('root')->put($file, file_get_contents($image));
            $path = base_path($file);
        }

        $result = $field == 'url'
            ? $this->mpApp->material->uploadArticleImage($path)
            : $this->mpApp->material->uploadImage($path);

        return $result[$field] ?? '';
    }

    /**
     * 替换内容中的图片
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    protected function replaceImage($content)
    {
        $imgResult = QueryList::html($content)->find('[style*="url"],img')->attrs('src');

        $images = $imgResult->all();

        foreach ($images as $image) {

            if (strstr('mmbiz.qpic.cn', $image) === false) {

                $mediaImage = $this->uploadImage($image);

                $content = str_replace($image, $mediaImage, $content);
            }
        }

        return $content;
    }
}
