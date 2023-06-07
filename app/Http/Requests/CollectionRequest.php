<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class CollectionRequest extends FormRequest
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
            'collect_name' => [
				'required',
                Rule::unique('collection')->where(function($query) use ($request, $pk) {
                    $query = $query->where('delete_flag', 0)->where('collect_name', $request['collect_name']);
                    if(!empty($pk)) {
                        $query->where('collect_id', '<>', $pk);
                    }
                })
			],
            'collect_img' => [
                'mimes:jpeg,png,jpg,gif,svg'
			],
        ];

        if(empty($request['edit'])){
            $rules['collect_img'] = 'required';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'collect_name.required' => 'Vui lòng nhập tên dòng sản phẩm',
            'collect_img.required' => 'Vui lòng chọn ảnh',
            'collect_img.mimes' => 'Vui lòng nhập đúng định dạng ảnh',
		];
    }
}