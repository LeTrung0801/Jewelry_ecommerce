<?php

namespace App\Http\Repositories;

class ProductRepository extends Repository{

	protected $modelName = 'Product';

	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

        if(!empty($conditions['keyword'])) {
			$query = $query->where('pro_name', 'like', '%'.$conditions['keyword'].'%');
		}

		if(!empty($conditions['keyword_id'])) {
			$query = $query->where('pro_name', 'like', '%'.$conditions['keyword_id'].'%')
							->orWhere('pro_id', 'like', '%'.$conditions['keyword_id']);
		}

		if(isset($conditions['material'])) {
			$query = $query->where('m_id', $conditions['material']);
		}

		if(isset($conditions['collect'])) {
			$query = $query->where('pro_collect_id', $conditions['collect']);
		}

		if(isset($conditions['category'])){
			$query = $query->where('pro_cat_id',$conditions['category']);
		}

		if(isset($conditions['delete_flag'])) {
            $query = $query->where('delete_flag', $conditions['delete_flag']);
        } else {
        	$query = $query->where('delete_flag', 0);
        }

		if(isset($conditions['quantity'])) {
            $query = $query->where('pro_qty', '>',$conditions['quantity']);
        }

        $query = $this->searchOptions($query, $options);
		return $query;
	}
}
