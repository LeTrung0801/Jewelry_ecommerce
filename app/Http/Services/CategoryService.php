<?php
namespace App\Http\Services;

class CategoryService extends Service{

	protected $modelName = 'Category';

	public function list(){
		
		$options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);
		return $list;
	}

    public function getList(){
        $options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);
        return $list;
    }

}