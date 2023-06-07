<?php

namespace App\Http\Repositories;

class CategoryRepository extends Repository{

	protected $modelName = 'Category';

	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

        if(!empty($conditions['keyword'])) {
			$query = $query->where('cat_name', 'like', '%'.$conditions['keyword'].'%');
		}

		if(isset($conditions['category'])){
			$query = $query->where('cat_id', $conditions['category']);
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
