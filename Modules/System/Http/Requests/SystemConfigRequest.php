<?php

namespace Modules\System\Http\Requests;

use App\Http\Requests\MyRequest;

class SystemConfigRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cfg_key' => [],
            'cfg_val' => [],
            'cfg_group' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
