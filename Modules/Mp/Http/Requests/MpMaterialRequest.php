<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpMaterialRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'mp_id' => [],
			'url' => [],
			'media_id' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
