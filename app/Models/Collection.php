<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collection';

    protected $primaryKey = 'collect_id';

    protected $guarded = [];

}
