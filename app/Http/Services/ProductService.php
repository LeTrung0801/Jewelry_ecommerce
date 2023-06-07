<?php
namespace App\Http\Services;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;

class ProductService extends Service{

	protected $modelName = 'Product';

	public function getListNew(){
		$conditions=[
            'quantity' => 0
        ];
		$options = [
            'get' => true,
			'orderbydesc' => 'pro_id',
			'limit' => 10
        ];
        $list = $this->repository()->search($conditions, $options);
        return $list;

	}

	public function getListCollect($collect){
		$conditions = [
			'collect' => $collect,
		];
		$options = [
            'get' => true,
			'orderbydesc' => 'pro_id',
			'limit' => 10
        ];
        $list = $this->repository()->search($conditions, $options);
        return $list;
	}

	public function getListCategory($category){
		$conditions = [
			'category' => $category
		];

		$options = [
			'get' => true,
			'orderbydesc' => 'pro_id',
			'limit' => 4
		];

		$list = $this->repository()->search($conditions,$options);
		return $list;

	}

}
