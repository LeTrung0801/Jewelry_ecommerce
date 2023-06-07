<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipt';

    protected $primaryKey = 'rep_id';

    protected $guarded = [];

    public function supplier()
	{
		return $this->belongsTo(Supplier::class, 'sup_id', 'sup_id');
	}

}
