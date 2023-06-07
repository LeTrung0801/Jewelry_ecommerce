<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $table = 'payment';
    protected $primaryKey = 'p_id';
    protected $guarded = [];
}
