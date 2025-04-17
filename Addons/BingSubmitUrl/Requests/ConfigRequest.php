<?php


namespace Addons\BingSubmitUrl\Requests;


use App\Http\Requests\MyRequest;

class ConfigRequest extends MyRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bing_api_key' => ['required', 'max:255'],
            'by_push_type' => [],
            'by_push_total' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'bing_api_key.required' => 'API-KEY 不能为空',
            'bing_api_key.max' => 'API-KEY 过长',
        ];
    }
}
