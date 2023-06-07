<?php

namespace App\Http\Repositories;

class SupplierRepository extends Repository{

	protected $modelName = 'Supplier';

	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

        if(!empty($conditions['keyword'])) {
			$query = $query->where('sup_name', 'like', '%'.$conditions['keyword'].'%');
		}

		if(isset($conditions['supplier'])){
			$query = $query->where('sup_id', $conditions['supplier']);
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
