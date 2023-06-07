<?php

namespace App\Http\Repositories;

class OrderDetailRepository extends Repository{

	protected $modelName = 'OrderDetail';

	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

		if(isset($conditions['order'])){
			$query = $query->where('o_id', $conditions['order']);
		}

		if(isset($conditions['delete_flag'])) {
            $query = $query->where('delete_flag', $conditions['delete_flag']);
        } else {
            $query = $query->where('delete_flag', 0);
        }

		$query = $this->searchOptions($query, $options);
		return $query;
	}
}
