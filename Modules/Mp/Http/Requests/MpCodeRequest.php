<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpCodeRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'mp_id' => [],
			'name' => [],
			'code_type' => [],
			'reply_type' => [],
			'reply_content' => [],
			'reply_image' => [],
			'tag_id' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
