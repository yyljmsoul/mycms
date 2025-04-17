<?php

namespace Modules\Order\Http\Requests;

use App\Http\Requests\MyRequest;

class OrderDeliveryRequest extends MyRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'delivery_type' => ['required'],
            'delivery_code' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_type.required' => '请选择快递公司',
            'delivery_code.required' => '请填写快递单号',
        ];
    }
}
