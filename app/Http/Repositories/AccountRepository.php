<?php

namespace App\Http\Repositories;

class AccountRepository extends Repository{

	protected $modelName = 'Account';

	public function search($conditions = [], $options = []) {
		$query = $this->model;

		if(!empty($conditions['keyword'])) {
			$query = $query->where('acc_name', 'like', '%'.$conditions['keyword'].'%');
		}

        // if(empty($conditions['except_admin'])) {
		// 	$query = $query->where('acc_role', '<>', '0');
		// }

		if(!empty($conditions['list_station_seq'])) {
			$query = $query->whereIn('station_seq', $conditions['list_station_seq']);
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
