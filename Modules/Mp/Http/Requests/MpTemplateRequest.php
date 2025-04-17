<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpTemplateRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'title' => [],
			'description' => [],
			'content' => [],
			'json_data' => [],
			'ds_type' => [],
			'db_table' => [],
			'db_condition' => [],
			'db_action' => [],
			'db_limit' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
