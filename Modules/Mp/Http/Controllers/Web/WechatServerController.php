<?php

namespace Modules\Mp\Http\Controllers\Web;

use App\Http\Controllers\MyController;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\BadRequestException;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Text;
use GuzzleHttp\Exception\GuzzleException;
use Modules\Mp\Models\MpAccountModel;
use Modules\Mp\Models\MpCodeModel;
use Modules\Mp\Models\MpUserModel;
use Modules\Mp\Service\MpService;
use Symfony\Component\HttpFoundation\Response;

class WechatServerController extends MyController
{

    protected $service;

    public function __construct()
    {
        $this->service = new MpService();
    }

    /**
     * @param $ident
     * @return Response
     * @throws InvalidConfigException
     * @throws BadRequestException
     * @throws InvalidArgumentException
     * @throws \ReflectionException
     */
    public function req($ident)
    {
        $account = $this->service->getMpAccount($ident);
        $wechat = $this->service->getMpObject($ident);

        $wechat->server->push(function ($message) use ($wechat, $account) {

            switch ($message['MsgType']) {
                case 'text':

                    $reply = $this->service->getReplyContent($account->id, 'accurate_match', $message['Content']);

                    if (!$reply) {
                        $reply = $this->service->getReplyContent($account->id, 'fuzzy_match', $message['Content']);
                    }

                    if (!$reply) {
                        $reply = $this->service->getReplyContent($account->id, 'not_match');
                    }

                    if ($reply) {

                        return $reply->reply_type == 'image' ?
                            new Image($reply->reply_media_id) :
                            new Text($reply->reply_content);
                    }

                    break;
                case 'event':
                    $event = strtolower($message['Event']);
                    if ($event == 'click') {
                        $menuClickContent = $this->service->getMenuClickContent($account->id, $message['EventKey']);
                        return $menuClickContent->event_image ?
                            new Image($menuClickContent->event_media_id) :
                            new Text($menuClickContent->event_text);
                    } elseif ($event == 'subscribe') {

                        $mpUser = MpUserModel::where('mp_id', $account->id)
                            ->where('openid', $message['FromUserName'])->first();

                        if (!$mpUser) {
                            $wxUser = $wechat->user->get($message['FromUserName']);
                            MpUserModel::insert([
                                'mp_id' => $account->id,
                                'openid' => $message['FromUserName'],
                                'unionid' => $wxUser['unionid'] ?? '',
                                'tagid_list' => json_encode($wxUser['tagid_list']),
                                'subscribe_scene' => $wxUser['subscribe_scene'],
                                'qr_scene' => $wxUser['qr_scene'],
                                'subscribe_time' => $wxUser['subscribe_time'],
                            ]);
                        }

                        if (isset($message['EventKey']) && $message['EventKey']) {
                            [$string, $value] = explode("_", $message['EventKey']);
                            $code = MpCodeModel::find($value);

                            if ($code) {
                                if ($code->tag_id) {
                                    $wechat->user_tag->tagUsers([$message['FromUserName']], $code->tag_id);
                                    $code->subscribe_count += 1;
                                    $code->scan_count += 1;
                                    $code->save();

                                    MpUserModel::where('mp_id', $account->id)
                                        ->where('openid', $message['FromUserName'])
                                        ->update([
                                            'tagid_list' => json_encode([$code->tag_id])
                                        ]);
                                }
                                return $code->reply_type == 'image' ?
                                    new Image($code->reply_media_id) :
                                    new Text($code->reply_content);
                            } else {
                                return new Text('欢迎关注~');
                            }
                        } else {
                            $reply = $this->service->getReplyContent($account->id, 'subscribe');
                            return $reply->reply_type == 'image' ?
                                new Image($reply->reply_media_id) :
                                new Text($reply->reply_content);
                        }
                    } elseif ($event == 'scan') {
                        if (isset($message['EventKey'])) {
                            $value = $message['EventKey'];
                            $code = MpCodeModel::find($value);

                            if ($code) {
                                if ($code->tag_id) {
                                    $wechat->user_tag->tagUsers([$message['FromUserName']], $code->tag_id);
                                    $code->scan_count += 1;
                                    $code->save();
                                }
                                return $code->reply_type == 'image' ?
                                    new Image($code->reply_media_id) :
                                    new Text($code->reply_content);
                            } else {
                                return new Text('欢迎回来~');
                            }
                        }
                    } elseif ($event == 'unsubscribe') {
                        MpUserModel::where('mp_id', $account->id)
                            ->where('openid', $message['FromUserName'])->delete();
                    }

                    break;
            }
        });

        return $wechat->server->serve();
    }

    /**
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function menu($ident)
    {

        $config = $this->service->getMpConfig($ident);

        $wechat = Factory::officialAccount($config);

        $wechat->menu->create([]);
    }
}
