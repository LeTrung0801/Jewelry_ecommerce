<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
    }

    public function passedValidation()
    {
    }

    public function rules()
    {
		$request = $this->request->all();
        $rules = [
            'city' => [
                'regex:/^((?!Chọn tỉnh thành).)*$/',
            ],
            'district' => [
                'regex:/^((?!Chọn quận huyện).)*$/',
            ],
            'ward' => [
                'regex:/^((?!Chọn phường xã).)*$/',
            ],
            'address' => [
                'required',
            ],
            'city1' => [
                'regex:/^((?!Chọn tỉnh thành).)*$/',
            ],
            'district1' => [
                'regex:/^((?!Chọn quận huyện).)*$/',
            ],
            'ward1' => [
                'regex:/^((?!Chọn phường xã).)*$/',
            ],
            'address1' => [
                'required',
            ],
            'payment' => [
                'required'
            ]
        ];

        if (!isset($request['new_add']))  {
            unset($rules['city']);
            unset($rules['district']);
            unset($rules['ward']);
            unset($rules['address']);
            unset($rules['city1']);
            unset($rules['district1']);
            unset($rules['ward1']);
            unset($rules['address1']);
        }

        if (isset($request['new_add']) && $request['new_add'] == 2)  {
            unset($rules['city']);
            unset($rules['district']);
            unset($rules['ward']);
            unset($rules['address']);
        }

        if (isset($request['new_add']) && $request['new_add'] == 1)  {
            unset($rules['city1']);
            unset($rules['district1']);
            unset($rules['ward1']);
            unset($rules['address1']);
        }
        return $rules;
    }


    public function messages()
    {
        return [
            'city.*' => 'Vui lòng chọn Thành Phố',
            'district.*' => 'Vui lòng chọn Quận Huyện',
            'ward.*' => 'Vui lòng chọn Phường Xã',
            'address.*' => 'Vui lòng nhập địa chỉ cụ thể',
            'city1.*' => 'Vui lòng chọn Thành Phố',
            'district2.*' => 'Vui lòng chọn Quận Huyện',
            'ward2.*' => 'Vui lòng chọn Phường Xã',
            'address2.*' => 'Vui lòng nhập địa chỉ cụ thể',
            'payment.*' => 'Vui lòng chọn phương thức thanh toán ',
		];
    }
}
