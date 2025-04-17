<?php


namespace Modules\User\Http\Requests;


use App\Http\Requests\MyRequest;

class UserAddressRequest extends MyRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'telephone' => ['required', 'max:25'],
            'province_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'district_id' => ['required', 'integer'],
            'address' => ['required', 'max:255'],
            'is_default' => [],
            'user_id' => [],
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => '收货人不能为空',
            'name.max' => '收货人长度错误',

            'telephone.required' => '联系电话不能为空',
            'telephone.max' => '联系电话长度错误',

            'province_id.required' => '请选择收货省份',
            'province_id.integer' => '收货省份格式错误',

            'city_id.required' => '请选择收货城市',
            'city_id.integer' => '收货城市格式错误',

            'district_id.required' => '请选择收货区县',
            'district_id.integer' => '收货区县格式错误',

            'address.required' => '详细地址不能为空',
            'address.max' => '详细地址长度错误',
        ];
    }

}
