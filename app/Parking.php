<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Parking extends Model
{
    //
    use softDeletes;

    protected $hidden = [
      'id'
    ];

    public function vehicules()
    {
      // code...
      return $this->hasMany(Vehicule::class);

    }
}
