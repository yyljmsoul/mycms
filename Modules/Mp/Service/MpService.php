<?php

namespace Modules\Mp\Service;

use App\Service\MyService;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\OfficialAccount\Application;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Mp\Models\MpAccountModel;
use Modules\Mp\Models\MpMaterialModel;
use Modules\Mp\Models\MpMenuModel;
use Modules\Mp\Models\MpReplyModel;
use Modules\Mp\Models\MpTagsModel;

class MpService extends MyService
{

    /**
     * 获取公众号对象
     * @param $ident
     * @param string $field
     * @return mixed
     */
    public function getMpAccount($ident, string $field = 'ident')
    {
        return MpAccountModel::where($field, $ident)->first();
    }


    /**
     * 获取公众号配置
     * @param $ident
     * @param string $field
     * @return array
     */
    public function getMpConfig($ident, string $field = 'ident'): array
    {
        $account = $this->getMpAccount($ident, $field);

        return $account ? [
            'app_id' => $account->app_id,
            'secret' => $account->app_key,
            'token' => $account->token,
            'response_type' => 'array',
            'aes_key' => $account->aes_key,
        ] : [];
    }


    /**
     * 获取公众号对象
     * @param $ident
     * @param string $field
     * @return Application
     */
    public function getMpObject($ident, string $field = 'ident'): \EasyWeChat\OfficialAccount\Application
    {
        $config = $this->getMpConfig($ident, $field);

        return Factory::officialAccount($config);
    }


    /**
     * 上传图片到素材库
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function uploadImage($image, $mpIdent)
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

        $result = $this->getMpObject($mpIdent, 'id')->material->uploadImage($path);
        $mediaId = $result['media_id'] ?? '';

        if ($mediaId) {

            MpMaterialModel::insert([
                'mp_id' => $mpIdent,
                'url' => $image,
                'media_id' => $mediaId,
            ]);
        }

        return $mediaId;
    }


    /**
     * 删除素材
     * @param $mpIdent
     * @param $mediaId
     * @return void
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function deleteImage($mpIdent, $mediaId)
    {
        $this->getMpObject($mpIdent, 'id')->material->delete($mediaId);
    }

    /**
     * 格式化菜单
     * @param $id
     * @return array
     */
    public function formatMenu($id): array
    {
        $formatMenu = [];

        $menus = MpMenuModel::where('mp_id', $id)->where('pid', 0)
            ->orderBy('id', 'asc')->orderBy('sort', 'desc')->get();

        foreach ($menus as $menu) {

            $subMenus = MpMenuModel::where('mp_id', $id)->where('pid', $menu->id)
                ->orderBy('id', 'asc')->orderBy('sort', 'desc')->get();

            if ($subMenus->count() > 0) {

                $child = [];
                foreach ($subMenus as $sub) {
                    $child[] = [
                        "type" => $sub->type,
                        "appid" => $sub->appid,
                        "pagepath" => $sub->path,
                        "name" => $sub->name,
                        "url" => $sub->url,
                        "key" => "Menu_{$id}_{$sub->id}"
                    ];
                }

                $formatMenu[] = [
                    'name' => $menu->name,
                    'sub_button' => $child,
                ];

            } else {

                $formatMenu[] = [
                    "type" => $menu->type,
                    "appid" => $menu->appid,
                    "pagepath" => $menu->path,
                    "name" => $menu->name,
                    "url" => $menu->url,
                    "key" => "Menu_{$id}_{$menu->id}"
                ];
            }
        }

        return $formatMenu;
    }


    /**
     * 获取菜单回复内容
     * @param $mpId
     * @param $key
     * @return mixed
     */
    public function getMenuClickContent($mpId, $key)
    {
        return MpMenuModel::where('mp_id', $mpId)->where('event_key', $key)->first();
    }


    /**
     * 获取菜单列表
     * @param $mpId
     * @param $pid
     * @return mixed
     */
    public function getMenus($mpId, $pid = 0)
    {
        return MpMenuModel::where('mp_id', $mpId)->where('pid', $pid)->get();
    }


    /**
     * 获取回复内容
     * @param $mpId
     * @param $type
     * @param $keyword
     * @return mixed
     */
    public function getReplyContent($mpId, $type, $keyword = '')
    {
        $query = MpReplyModel::where('mp_id', $mpId)->where('type', $type);

        if ($type == 'accurate_match') {
            $result = $query->where('keyword', $keyword)->first();
        } elseif ($type == 'fuzzy_match') {
            $result = $query->where('keyword', 'like', "%{$keyword}%")->first();
        } else {
            $result = $query->first();
        }

        return $result;
    }


    /**
     * 公众号用户标签
     * @param $mpId
     * @return mixed
     */
    public function getMpTags($mpId)
    {
        return MpTagsModel::where('mp_id', $mpId)->get();
    }

}
