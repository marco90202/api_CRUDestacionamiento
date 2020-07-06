<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){

  Route::post('loginazo', 'Access\AccessController@loginazo');
  Route::post('register', 'Access\AccessController@register');

  Route::get('clients', 'ClientController@index');
  Route::get('clients/{client}', 'ClientController@show');
  Route::post('clients', 'ClientController@store');
  Route::post('clients/{client}', 'ClientController@update');
  Route::delete('clients/{client}','ClientController@destroy');
  Route::put('clients/{client}/restore', 'ClientController@restore');

  Route::get('vehicules', 'VehiculeController@index');
  Route::get('vehicules/{vehicule}', 'VehiculeController@show');
  Route::post('vehicules', 'VehiculeController@store');
  Route::post('vehicules/{vehicule}', 'VehiculeController@update');
  Route::delete('vehicules/{vehicule}','VehiculeController@destroy');
  Route::put('vehicules/{vehicule}/restore', 'VehiculeController@restore');


});
