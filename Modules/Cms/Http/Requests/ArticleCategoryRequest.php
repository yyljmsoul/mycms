<?php


namespace Modules\Cms\Http\Requests;


use App\Http\Requests\MyRequest;

class ArticleCategoryRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pid' => ['required'],
            'name' => ['required','max:255'],
            'description' => ['max:255'],
            'img' => [],
            'redirect_url' => [],
            'keyword' => [],
            'template' => [],
            'sub_name' => [],
            'single_template' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'pid.required' => '必须选择上级菜单',
            'name.required' => '名称必须填写',
            'name.max' => '名称长度错误',

            'description.max' => '描述说明长度错误',
        ];
    }
}
