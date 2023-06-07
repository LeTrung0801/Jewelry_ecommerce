<?php
namespace App\Http\Repositories;

use App\Http\Helpers\AppData;

class Repository {

	protected $modelName;

	protected $model;

	public function __construct() {
		$class = "App\\Models\\$this->modelName";
		return $this->model = new $class;
	}

	public function findAll() {
		return $this->model;
	}

	public function findByPk($pk, $relations = []) {
		$query = $this->model;
		if(!empty($relations)) {
			foreach($relations as $relation) {
				$query = $query->with($relation);
			}
		}
		return $query->find($pk);
	}

	public function findAllActive() {
		return $this->model;
	}

	public function create($data) {
		return $this->model->create($data);
	}

	public function updateOrInsert($conditions, $update) {
		return $this->model->updateOrInsert(
	        $conditions,
	        $update
	    );
	}

	public function updateByPk($pk, $data) {
		return $this->findByPk($pk)->update($data);
	}

	public function deleteByPk($pk) {
		return $this->findByPk($pk)->delete();
	}

	public function insertData($data) {
		return $this->model->insert($data);
	}

	public function searchOptions($query, $options = []) {
		if(!empty($options['select'])) {
			$query = $query->select($options['select']);
		}

		if(!empty($options['orderbydesc'])) {
			$query = $query->orderBy($options['orderbydesc'],'desc');
		}

		if(!empty($options['sort'])) {
			foreach($options['sort'] as $key => $value) {
				$type = str_replace('sorting_', '', $value);
				$query = $query->orderBy($key, $type);
			}
		}

		if(!empty($options['sort_raw'])) {
			foreach($options['sort_raw'] as $index => $raw) {
				$string = str_replace('sorting_', '', $raw);
				$query = $query->orderByRaw($string);
			}
		}

		if(!empty($options['with'])) {
			foreach($options['with'] as $key => $function) {
				$query = $query->with([$key => $function]);
			}
		}

		if(!empty($options['withCount'])) {
			foreach($options['withCount'] as $key => $function) {
				$query = $query->withCount([$key => $function]);
			}
		}

		if(!empty($options['groupBy'])) {
			$query = $query->groupBy($options['groupBy']);
		}

		if(!empty($options['distinct'])) {
			$query = $query->distinct($options['distinct']);
		}

		if(!empty($options['offset'])) {
			$query = $query->offset($options['offset']);
		}

		if(!empty($options['limit'])) {
			$query = $query->limit($options['limit']);
		}

		if(!empty($options['get'])) {
			$query = $query->get();
		} else if(!empty($options['paginate'])){
			$query = $query->paginate($options['paginate']);
		} else if(!empty($options['pluck'])) {
			$query = $query->pluck($options['pluck'], $this->model->getKeyName());
		} else if(!empty($options['count'])) {
			$query = $query->count();
		} else if(!empty($options['first'])) {
			$query = $query->first();
		} else if(!empty($options['query'])) {
			$query = $query;
		} else if(!empty($options['findByPk'])) {
			$query = $query->find($options['findByPk']);
		} else if(!empty($options['update'])) {
			$query = $query->update($options['update']);
		} else if(!empty($options['delete'])) {
			$query->delete();
		} else {
			$query = $query->paginate(AppData::defaultPaginate);
		}

		if(!empty($options['groupBy'])) {
			$query = $query->groupBy($options['groupBy']);
		}

		return $query;
	}
}



