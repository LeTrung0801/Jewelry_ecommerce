<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'pro_id';

    protected $guarded = [];

    public function category()
	{
		return $this->belongsTo(Category::class, 'pro_cat_id', 'cat_id');
	}

    public function collection()
	{
		return $this->belongsTo(Collection::class, 'pro_collect_id', 'collect_id');
	}

    public function menu(){
        return $this->hasOne(Category::class, 'cat_id', 'pro_cat_id')
        ->withDefault(['pro_name' => '']);
    }

}
