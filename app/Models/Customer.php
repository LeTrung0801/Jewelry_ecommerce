<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    //
    protected $table = 'customer';

    protected $primaryKey = 'cus_id';

    protected $guarded = [];

    protected $hidden = [
        'cus_pwd'
    ];

    public function getAuthPassword() {
        return $this->cus_pwd;
    }

    public function getCity()
    {
        return $this->belongsTo(District::class, 'city_id', 'matp');
    }

    public function getDistrict()
    {
        return $this->belongsTo(District::class, 'dis_id', 'maqh');
    }

    public function getWard()
    {
        return $this->belongsTo(District::class, 'ward_id', 'xaid');
    }
}
