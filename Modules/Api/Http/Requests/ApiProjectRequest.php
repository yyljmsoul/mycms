<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\MyRequest;

class ApiProjectRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'description' => [],
			'ident' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
