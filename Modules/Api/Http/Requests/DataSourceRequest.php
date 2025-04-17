<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\MyRequest;

class DataSourceRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'fields' => [],
			'remark' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
