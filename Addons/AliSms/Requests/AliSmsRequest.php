<?php


namespace Addons\AliSms\Requests;


use App\Http\Requests\MyRequest;

class AliSmsRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'access_key' => ['required', 'max:255'],
            'access_secret' => ['required', 'max:255'],
            'sign_name' => ['required', 'max:255'],
            'template_code' => ['required', 'max:255'],
            'is_default' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'access_key.required' => '请输入名称',
            'access_key.max' => '名称长度错误',
            'access_secret.required' => '请输入URL',
            'access_secret.max' => 'URL长度错误',
            'sign_name.required' => '请选择打开方式',
            'sign_name.max' => '打开方式长度错误',
            'template_code.required' => '请输入排序',
            'template_code.max' => '请输入排序',
            'is_default.required' => '请选择是否为默认模板',
        ];
    }
}
