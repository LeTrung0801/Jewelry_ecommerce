<?php
namespace App\Http\Services;

class SupplierService extends Service{

	protected $modelName = 'Supplier';

    public function getList(){
        $options = [
            'get' => true,
        ];
        $list = $this->repository()->search([], $options);
        return $list;
    }
}
