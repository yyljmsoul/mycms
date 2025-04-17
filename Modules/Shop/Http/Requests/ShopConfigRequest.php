<?php

namespace Modules\Shop\Http\Requests;

use App\Http\Requests\MyRequest;

class ShopConfigRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_name' => [],
            'search_hot_keywords' => [],
            'shop_service_telephone' => [],
            'shop_work_time' => [],
            'system_freight_total' => [],
            'system_freight_money' => [],
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
}
