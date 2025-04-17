<?php

namespace Addons\MsgBoard\Requests;

use App\Http\Requests\MyRequest;

class MsgBoardSubmitRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['email', 'max:255'],
            'phone' => ['max:255'],
            'first_name' => ['max:255'],
            'last_name' => ['max:255'],
            'subject' => ['max:255'],
            'content' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Email格式错误',
            'email.max' => 'Email长度错误',
            'phone.max' => '手机号码长度错误',
            'subject.max' => '主题长度错误',
            'content.required' => '内容不能为空',
        ];
    }
}
