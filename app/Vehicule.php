<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Vehicule extends Model
{
    //
    use softDeletes;
    protected $fillable = [
      'brand','plate','client_id'
    ];

    

    public function client()
    {
      // code...
      return $this->belongsTo(Client::class);
    }

    public function Parking()
    {
      // code...
      return $this->belongsTo(Parking::class);
    }

}
