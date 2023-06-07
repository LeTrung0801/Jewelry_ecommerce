<?php
namespace App\Http\Services;

class OrderDetailService extends Service{

	protected $modelName = 'OrderDetail';

	public function list(){
		$condition = [
			
		];

		$options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);

		return $list;
	}

}
