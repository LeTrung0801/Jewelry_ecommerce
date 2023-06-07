<?php

namespace App\Http\Repositories;

class OrderRepository extends Repository{

	protected $modelName = 'Order';

	public function search($conditions = [], $options = []) {
		$query = $this->findAllActive();

		if(isset($conditions['keyword'])){
			$query = $query->where('o_id', 'like' , '%'.$conditions['keyword']);
		}
		if(isset($conditions['order'])){
			$query = $query->where('o_id', $conditions['order']);
		}

		if(isset($conditions['o_status'])){
			if($conditions['o_status'] == 0){
				$query = $query->where('o_status',$conditions['o_status'])->orWhere('o_status',1);
			}else if($conditions['o_status'] == 2){
				$query = $query->where('o_status',$conditions['o_status']);
			}else {
				$query = $query->where('o_status',$conditions['o_status']);
			}
		}

		if(isset($conditions['cus_id'])){
			$query = $query->where('cus_id', $conditions['cus_id']);
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