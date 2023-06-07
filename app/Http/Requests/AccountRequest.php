<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class AccountRequest extends FormRequest
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
            'acc_email' => [
				'required',
                'email'
			],
            'acc_pwd' => [
                'required'
            ],
            'acc_pwd_conf' =>[
                'required',
                'same:acc_pwd'
            ],
            'acc_role' =>[
                'required'
            ],
            'acc_name' =>[
                'required'
            ],
            'acc_phone' =>[
                'nullable'
            ]
        ];

        if (!isset($request['acc_pwd_conf']))  {
            unset($rules['acc_pwd_conf']);
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'acc_role.requied' => 'acc_role.requied',
            'acc_name.requied' => 'acc_name.requied',
            'acc_email.required' => 'Vui lòng nhập email',
            'acc_email.email' => 'Email không hợp lệ',
            'acc_pwd.required' => 'Vui lòng nhập mật khẩu',
            'acc_phone.*' => 'acc_role.number',
            'acc_pwd_conf.*' => 'Mật khẩu không khớp',
		];
    }
}
