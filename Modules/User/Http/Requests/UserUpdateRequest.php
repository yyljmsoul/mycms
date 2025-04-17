<?php


namespace Modules\User\Http\Requests;


use App\Http\Requests\MyRequest;

class UserUpdateRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = request()->input('id');

        return [
            'id' => ['required'],
            'name' => ['required', 'unique:my_user,name,' . $id . ',id', 'max:50'],
            'nickname' => ['max:50'],
            'rank' => ['integer'],
            'mobile' => ['required', 'unique:my_user,mobile,' . $id . ',id', 'size:11'],
            'openid' => [],
            'unionid' => [],
            'img' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => '非法参数',
            'mobile.required' => '手机号码不能为空',
            'mobile.unique' => '手机号码已存在',
            'mobile.size' => '手机号码格式错误',
            'nickname.max' => '用户昵称过长',
        ];
    }
}
