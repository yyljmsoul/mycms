<?php

namespace Modules\Mp\Http\Requests;

use App\Http\Requests\MyRequest;

class MpArticleRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
			'title' => [],
			'author' => [],
			'digest' => [],
			'content' => [],
			'content_source_url' => [],
			'thumb' => [],

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
