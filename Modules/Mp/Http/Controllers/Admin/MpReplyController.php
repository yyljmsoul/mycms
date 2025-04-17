<?php

namespace Modules\Mp\Http\Controllers\Admin;

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;

class MpReplyController extends MpController
{
    public $view = 'admin.mp_reply.';

    public $model = 'Modules\Mp\Models\MpReplyModel';

    public $request = 'Modules\Mp\Http\Requests\MpReplyRequest';

    public $with = ['mp'];


    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function afterStore($id)
    {
        $reply = $this->getModel()->where('id', $id)->first();

        if ($reply->reply_type == 'image' && $reply->reply_image) {
            $reply->reply_media_id = $this->service->uploadImage($reply->reply_image, $reply->mp_id);
            $reply->save();
        }
    }


    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function afterUpdate($id)
    {
        $reply = $this->getModel()->where('id', $id)->first();

        if ($reply->reply_type == 'image' && $reply->reply_image) {

            if ($reply->reply_media_id) {
                $this->service->deleteImage($reply->mp_id, $reply->reply_media_id);
            }

            $reply->reply_media_id = $this->service->uploadImage($reply->reply_image, $reply->mp_id);
            $reply->save();
        }
    }
}
