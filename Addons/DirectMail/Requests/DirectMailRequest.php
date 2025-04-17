<?php

namespace Addons\DirectMail\Requests;

use App\Http\Requests\MyRequest;

class DirectMailRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'access_key' => ['required', 'max:50'],
            'access_secret' => ['required', 'max:50'],
            'account_name' => ['required', 'max:255'],
            'remark' => [],
            'region' => [],
            'alias' => [],
            'is_default' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'access_key.required' => '请输入 access_key',
            'access_key.max' => 'access_key 长度错误',
            'access_secret.required' => '请输入 access_secret',
            'access_secret.max' => 'access_secret 长度错误',
            'account_name.required' => '请输入发件地址',
            'account_name.max' => '发件地址长度错误',
            'is_default.required' => '请选择是否为默认模板',
        ];
    }
}
