<?php 

namespace App\Http\Services;

use Validator;

class Service {

	protected $modelName;

	public function repository() {
		$modelName = $this->modelName;
		$class = "App\\Http\\Repositories\\$this->modelName"."Repository";
		return $instanceRepository = new $class;
	}

}