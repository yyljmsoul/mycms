<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpPushLogRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'article_id' => [],
			'appid' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
