<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpUserRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'mp_id' => [],
			'openid' => [],
			'unionid' => [],
			'tagid_list' => [],
			'subscribe_scene' => [],
			'qr_scene' => [],
			'subscribe_time' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
