<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;

class Account extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'account';

    protected $primaryKey = 'acc_id';

    protected $guarded = [];

    protected $hidden = [
        'acc_pwd'
    ];

    public function getAuthPassword() {
        return $this->acc_pwd;
    }
}
