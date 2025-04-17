<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpReplyRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'mp_id' => [],
			'type' => [],
			'keyword' => [],
			'reply_content' => [],
			'reply_type' => [],
			'reply_image' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
