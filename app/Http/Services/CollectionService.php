<?php
namespace App\Http\Services;

class CollectionService extends Service{

    protected $modelName = 'Collection';
    
    public function list(){
		
		$options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);
		return $list;
    }
    
    public function getList(){
        $options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);
        return $list;
    }

}