<?php

namespace Addons\MsgBoard\Requests;

use App\Http\Requests\MyRequest;

class MsgBoardAdminRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['max:255'],
            'phone' => ['max:255'],
            'subject' => ['max:255'],
            'content' => ['required'],
            'status' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'email.max' => 'Email长度错误',
            'phone.max' => '手机号码长度错误',
            'subject.max' => '主题长度错误',
            'content.required' => '内容不能为空',
        ];
    }
}
