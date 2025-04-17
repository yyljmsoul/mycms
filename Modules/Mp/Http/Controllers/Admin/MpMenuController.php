<?php

namespace Modules\Mp\Http\Controllers\Admin;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

class MpMenuController extends MpController
{
    public $view = 'admin.mp_menu.';

    public $model = 'Modules\Mp\Models\MpMenuModel';

    public $request = 'Modules\Mp\Http\Requests\MpMenuRequest';


    /**
     * 首页
     */
    public function index()
    {
        if (request()->ajax() && request()->wantsJson()) {

            $data = $this->getModel()::with($this->with)
                ->where($this->getIndexWhere())
                ->orderBy('sort', 'desc')
                ->orderBy('id', 'asc')
                ->paginate($this->param('limit', 'intval'))
                ->toArray();

            return $this->success($data);
        }

        return $this->view($this->view . 'index');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function afterStore($id)
    {
        $menu = $this->getModel()->where('id', $id)->first();

        if ($menu->type == 'click' && $menu->event_image) {
            $menu->event_media_id = $this->service->uploadImage($menu->event_image, $menu->mp_id);
        }

        $menu->event_key = "Menu_{$menu->mp_id}_{$id}";
        $menu->save();
    }


    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function afterUpdate($id)
    {
        $menu = $this->getModel()->where('id', $id)->first();

        if ($menu->type == 'click') {

            if ($menu->event_media_id) {
                $this->service->deleteImage($menu->mp_id, $menu->event_media_id);
            }

            if ($menu->event_image) {
                $menu->event_media_id = $this->service->uploadImage($menu->event_image, $menu->mp_id);
                $menu->save();
            }
        }
    }


    /**
     * 删除操作
     * @param $id
     * @return mixed
     */
    public function afterDestroy($id)
    {
        return $this->getModel()->where('pid', $id)->delete();
    }

    /**
     * 发布菜单
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function release(): \Illuminate\Http\JsonResponse
    {
        $ident = $this->param('mp_id');

        $wechat = $this->service->getMpObject($ident, 'id');

        $result = $wechat->menu->create($this->service->formatMenu($ident));

        return $result['errcode'] == 0
            ? $this->success() : $this->error();
    }
}
