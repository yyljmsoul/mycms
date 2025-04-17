<?php

namespace Modules\Mp\Http\Controllers\Admin;

use App\Http\Controllers\MyAdminController;
use Modules\Mp\Models\MpCodeModel;
use Modules\Mp\Models\MpTagsModel;

class MpUserController extends MyAdminController
{
    public $view = 'admin.mp_user.';

    public $model = 'Modules\Mp\Models\MpUserModel';

    public $request = 'Modules\Mp\Http\Requests\MpUserRequest';

    public $scene = [
        'ADD_SCENE_SEARCH' => '公众号搜索',
        'ADD_SCENE_ACCOUNT_MIGRATION' => '公众号迁移',
        'ADD_SCENE_PROFILE_CARD' => '名片分享',
        'ADD_SCENE_QR_CODE' => '扫描二维码',
        'ADD_SCENE_PROFILE_LINK' => '图文页内名称点击',
        'ADD_SCENE_PROFILE_ITEM' => '图文页右上角菜单',
        'ADD_SCENE_PAID' => '支付后关注',
        'ADD_SCENE_WECHAT_ADVERTISEMENT' => '微信广告',
        'ADD_SCENE_REPRINT' => '他人转载',
        'ADD_SCENE_LIVESTREAM' => '视频号直播',
        'ADD_SCENE_CHANNELS' => '视频号',
        'ADD_SCENE_OTHERS' => '其他',
    ];

    /**
     * 首页
     */
    public function index($ident)
    {
        if (request()->ajax() && request()->wantsJson()) {

            $data = $this->getModel()::with($this->with)
                ->where('mp_id', $ident)
                ->orderBy($this->indexOrderBy, $this->indexSort)
                ->paginate($this->param('limit', 'intval'))
                ->toArray();

            foreach ($data['data'] as &$value) {

                $value['subscribe_time'] = date('Y-m-d H:i:s', $value['subscribe_time']);
                $value['tags'] = '';
                $tags = json_decode($value['tagid_list'], true) ?: [];
                if ($tags) {
                    $tags = MpTagsModel::whereIn('tag_id', $tags)->get()->toArray();
                    $value['tags'] = join(',', array_column($tags, 'name'));
                }

                if ($value['qr_scene']) {
                    $code = MpCodeModel::find($value['qr_scene']);
                    $value['qr_scene'] = $code->name;
                } else {
                    $value['qr_scene'] = '否';
                }

                $value['subscribe_scene'] = $this->scene[$value['subscribe_scene']] ?? '';

            }

            return $this->success($data);
        }

        return $this->view($this->view . 'index');
    }
}
