<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'address', 'number', 'city', 'zip_code'];

    protected $hidden = ['password'];
    
    public function getJWTCustomClaims() 
    {
        return [];
    }

    public function getJWTIdentifier() 
    {
        return $this->getKey();
    }

}
