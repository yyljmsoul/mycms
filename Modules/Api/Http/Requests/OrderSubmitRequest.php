<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\MyRequest;

class OrderSubmitRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_id' => ['required'],
            'param_json' => ['required'],
            'remark' => [],
        ];
    }

    public function messages(): array
    {
        return [
            'address_id.required' => '请选择收货地址',
            'param_json.required' => '请选择结算商品',
        ];
    }
}
