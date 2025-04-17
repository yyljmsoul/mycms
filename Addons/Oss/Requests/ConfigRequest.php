<?php


namespace Addons\Oss\Requests;


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
            'oss_access_key_id' => ['required', 'max:255'],
            'oss_access_key_secret' => ['required', 'max:255'],
            'oss_endpoint' => ['required', 'max:255'],
            'oss_bucket' => ['required', 'max:255'],
            'oss_url' => ['max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'oss_access_key_id.required' => 'oss_access_key_id不能为空',
            'oss_access_key_id.max' => 'oss_access_key_id长度错误',
            'oss_access_key_secret.required' => 'oss_access_key_secret不能为空',
            'oss_access_key_secret.max' => 'oss_access_key_secret长度错误',
            'oss_endpoint.required' => 'oss_endpoint不能为空',
            'oss_endpoint.max' => 'oss_endpoint长度错误',
            'oss_bucket.required' => 'oss_bucket不能为空',
            'oss_bucket.max' => 'oss_bucket长度错误',
            'oss_url.max' => '自定义域名长度错误',
        ];
    }

}
