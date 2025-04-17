<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\MyRequest;

class ApiRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'path' => [],
			'method' => [],
			'table_name' => [],
			'request_url' => [],
			'source_type' => [],
			'return_type' => [],
			'handle' => [],
			'count_field' => [],
            'project_ident' => [],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
