<?php

namespace Modules\Mp\Http\Controllers\Admin;


use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MpCodeController extends MpController
{
    public $view = 'admin.mp_code.';

    public $model = 'Modules\Mp\Models\MpCodeModel';

    public $request = 'Modules\Mp\Http\Requests\MpCodeRequest';

    public $with = ['mp'];


    public function afterStore($id)
    {
        $code = $this->getModel()->where('id', $id)->first();

        $mp = $this->service->getMpObject($code->mp_id, 'id');

        if ($code->code_type == 'forever') {
            $result = $mp->qrcode->forever($id);
        } else {
            $result = $mp->qrcode->temporary($id, 30 * 24 * 3600);
        }

        $url = $mp->qrcode->url($result['ticket']);

        $date = date('Ym/d');
        $disk = system_config('site_upload_disk');
        $path = 'public/uploads/codes/' . $date . '/' . Str::random(40) . ".png";

        Storage::disk($disk)
            ->put($path, file_get_contents($url));

        if ($code->reply_type == 'image' && $code->reply_image) {
            $code->reply_media_id = $this->service->uploadImage($code->reply_image, $code->mp_id);
        }

        $code->code_image = system_image_url($path);
        $code->save();
    }


    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws InvalidConfigException
     */
    public function afterUpdate($id)
    {
        $code = $this->getModel()::find($id);

        if ($code->reply_type == 'image' && $code->reply_image) {

            if ($code->reply_media_id) {
                $this->service->uploadImage($code->mp_id, $code->reply_media_id);
            }

            $code->reply_media_id = $this->service->uploadImage($code->reply_image, $code->mp_id);
            $code->save();
        }
    }
}
