<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    protected $table = 'order_detail';

    protected $guarded = [];

    public function getProduct()
	{
		return $this->belongsTo(Product::class, 'pro_id', 'pro_id');
	}
}
