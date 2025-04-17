<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpMenuRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'mp_id' => [],
			'pid' => [],
			'sort' => [],
			'name' => [],
			'type' => [],
			'url' => [],
			'appid' => [],
			'path' => [],
			'event_text' => [],
			'event_image' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
