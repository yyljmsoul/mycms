<?php

namespace Modules\Api\Http\Requests;

use App\Http\Requests\MyRequest;

class PaySubmitRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_sn' => ['required'],
            'pay_type' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'order_sn.required' => '订单号不能为空',
            'pay_type.required' => '请选择支付方式',
        ];
    }
}
