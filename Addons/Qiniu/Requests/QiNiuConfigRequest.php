<?php

namespace Addons\Qiniu\Requests;

use App\Http\Requests\MyRequest;

class QiNiuConfigRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'qn_access' => ['required', 'max:255'],
            'qn_secret' => ['required', 'max:255'],
            'qn_bucket' => ['required', 'max:255'],
            'qn_url' => ['required', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'qn_access.required' => 'access 不能为空',
            'qn_access.max' => 'access 长度错误',
            'qn_secret.required' => 'secret 不能为空',
            'qn_secret.max' => 'secret 长度错误',
            'qn_bucket.required' => 'bucket 不能为空',
            'qn_bucket.max' => 'bucket 长度错误',
            'qn_url.required' => '自定义域名不能为空',
            'qn_url.max' => '自定义域名长度错误',
        ];
    }
}
