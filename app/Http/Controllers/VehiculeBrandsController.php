<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehiculeBrands;

class VehiculeBrandsController extends ApiController
{
    //
    public function index()
    {
      // code...
      $VehiculeBrands = VehiculeBrands::all();

      return $this->sendResponse($VehiculeBrands,'Marcas de vehiculos.');
    }
}
