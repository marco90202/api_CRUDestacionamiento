<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\softDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    //
    use HasApiTokens, softDeletes;

    protected $fillable = [
      'firstname','lastname','email','password'
    ];

    protected $hidden = [
      'password','remember_token'
    ];


    public function vehicules()
    {
      // code...
      return $this->hasMany(Vehicule::class);
    }
}
