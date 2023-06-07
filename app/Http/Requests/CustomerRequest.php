<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class CustomerRequest extends FormRequest
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
        // dd($request);
        $rules = [
            'user_name' => [
				'required',
			],
            'user_phone' => [
				'required',
                'regex:/^[0]+[3|5|7|9]+[0-9]{8,9}/u',
			],
            'user_email' => [
				'required',
                'email'
			],
            'user_password' => [
                'required',
                'max:100',
            ],
            'user_password_confirm' => [
                'required',
                'same:user_password'
            ],
            'city' => [
                'regex:/^((?!Chọn tỉnh thành).)*$/',
            ],
            'district' => [
                'regex:/^((?!Chọn quận huyện).)*$/',
            ],
            'ward' => [
                'regex:/^((?!Chọn phường xã).)*$/',
            ],
            'cus_add' => [
                'required',
            ],
        ];

        if(!isset($request['type'])) {
            unset($rules['city']);
            unset($rules['district']);
            unset($rules['ward']);
            unset($rules['cus_add']);
        } else {
            unset($rules['user_password_confirm']);
        }

        if(empty($request['user_password'])) {
            unset($rules['user_password']);
            unset($rules['user_password_confirm']);
        }
        return $rules;
    }


    public function messages()
    {
        return [
            'user_name.required' => 'Không bỏ trống họ tên',
            'user_phone.required' => 'Không bỏ trống Số điện thoại',
            'user_phone.regex' => 'Số điện thoại sai định dạng',
            'user_email.required' => 'Không bỏ trống email',
            'user_email.email' => 'Email không hợp lệ',
            'user_password.required' => 'Không bỏ trống password',
            'user_password_confirm.required' => 'Xác nhận password',
            'user_password_confirm.*' => 'Password không trùng khớp',
		];
    }
}
