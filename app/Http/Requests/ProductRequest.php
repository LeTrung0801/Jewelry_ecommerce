<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class ProductRequest extends FormRequest
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
        $pk = $this->route()->parameter('pk');

        $rules = [
            'pro_name' => [
				'required',
                Rule::unique('product')->where(function($query) use ($request, $pk) {
                    $query = $query->where('delete_flag', 0)->where('pro_name', $request['pro_name']);
                    if(!empty($pk)) {
                        $query->where('pro_id', '<>', $pk);
                    }
                })
			],
            'pro_price' => [
				'required',
                'numeric',
                'gt:1000'
			],
            'pro_price_sale' => [
				'nullable',
                'numeric',
                'gt:1000'
			],
            'img_1' => [
                'mimes:jpeg,png,jpg,gif,svg'
			],
            'img_2' => [
                'mimes:jpeg,png,jpg,gif,svg'
			],
            'pro_qty' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'm_id' => [
                'required',
            ],
            'pro_cat_id' => [
                'required',
                'numeric',
            ],
            'pro_description' => [
                'nullable',
            ],
        ];

        if(empty($request['edit'])){
            $rules['img_1'] = 'required';
            $rules['img_2'] = 'required';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            // 'user_name.required' => 'Không bỏ trống họ tên',
            // 'user_phone.required' => 'Không bỏ trống Số điện thoại',
            // 'user_email.required' => 'Không bỏ trống email',
            // 'user_email.email' => 'Email không hợp lệ',
            // 'user_password.required' => 'Không bỏ trống password',
            // 'user_password_confirm.required' => 'Xác nhận password',
            // 'user_password_confirm.*' => 'Password không trùng khớp',
		];
    }
}
