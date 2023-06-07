<?php
namespace App\Http\Services;

class AccountService extends Service{

	protected $modelName = 'Account';

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
