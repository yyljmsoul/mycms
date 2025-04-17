<?php


namespace Modules\Shop\Http\Requests;


use App\Http\Requests\MyRequest;

class CartStoreRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'goods_id' => ['required', 'integer'],
            'number' => ['required', 'integer'],
            'sku_id' => [],
            'direct' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'goods_id.required' => '商品信息缺失',
            'goods_id.integer' => '商品信息错误',
            'number.required' => '商品数量缺失',
            'number.integer' => '商品数量错误',
        ];
    }
}
