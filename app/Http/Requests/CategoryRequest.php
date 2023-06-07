<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use AppData;

class CategoryRequest extends FormRequest
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
            'cat_name' => [
				'required',
                Rule::unique('category')->where(function($query) use ($request, $pk) {
                    $query = $query->where('delete_flag', 0)->where('cat_name', $request['cat_name']);
                    if(!empty($pk)) {
                        $query->where('cat_id', '<>', $pk);
                    }
                })
			],
            'cat_img' => [
                'mimes:jpeg,png,jpg,gif,svg'
			],
        ];

        if(empty($request['edit'])){
            $rules['cat_img'] = 'required';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'cat_name.required' => 'Vui lòng nhập tên danh mục',
            'cat_img.required' => 'Vui lòng chọn ảnh',
            'cat_img.mimes' => 'Vui lòng nhập đúng định dạng ảnh',
		];
    }
}