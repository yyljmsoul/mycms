<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpAccountRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'type' => [],
			'app_id' => [],
			'app_key' => [],
			'token' => [],
			'aes_key' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
