<?php

namespace Modules\Cms\Http\Requests;

use App\Http\Requests\MyRequest;

class ArticleGroupRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'name' => [],
			'category_id' => [],
			'sort' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
