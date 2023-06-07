<?php
namespace App\Http\Services;

class CustomerService extends Service{

	protected $modelName = 'Customer';

    public function list($keyword){
        $conditions = [
            'keyword' => $keyword,
		];
        $options = [
            'get' => true,
        ];
        $list = $this->repository()->search($conditions, $options);

		return $list;
	}

}
