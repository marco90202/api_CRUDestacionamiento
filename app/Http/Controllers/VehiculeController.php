<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicule;
use Validator;


class VehiculeController extends ApiController
{
    //
    public function index()
    {
      // code...
      $vehicules = Vehicule::all();

      return $this->sendResponse($vehicules,'Vehiculos activos.');

    }


    public function show($vehicule, Request $request)
    {
      // code...
      if(!is_numeric($vehicule)) return $this->sendError('Parametro debe ser numerico.');

      $vehiculeFinded = Vehicule::find($vehicule);
      if($vehiculeFinded == null) return $this->sendError('No existe el vehiculo igresado.');

      return $this->sendResponse($vehiculeFinded, 'Informacion del vehiculo.');
    }




    public function store(Request $request)
    {
      //dd($request->all());
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string',
            'plate' => 'required|string'
        ]);

        if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);

        $vehicule = new Vehicule();
        $vehicule->brand = $request->brand;
        $vehicule->plate = $request->plate;
        $vehicule->client_id = 1;
        $vehicule->save();

        return $this->sendResponse($vehicule, 'Vehiculo asignado existosamente.');

    }




    public function update($vehicule, Request $request)
    {
      // code...
      if(!is_numeric($vehicule)) return $this->sendError('Parametro debe ser numerico.');

      $vehiculeFinded = Vehicule::find($vehicule);
      if($vehiculeFinded == null) return $this->sendError('No existe el vehiculo igresado.');

      $validator = Validator::make($request->all(), [
          'brand' => 'nullable|string',
          'plate' => 'nullable|string'
      ]);
      if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);

      $data = $request->input();

      if(sizeof($data) > 0){
        $vehiculeFinded->fill($data)->save();
        $msg = 'Se actualizó la información del vehiculo.';

      }else{
        $msg = 'No se pudo actualizar la información del vehiculo.';
      }

      return $this->sendResponse($vehiculeFinded,$msg);

    }






    public function destroy($vehicule)
    {
      // code...
      if(!is_numeric($vehicule)) return $this->sendError('Parametro no valido.');
      $vehiculeFinded = Vehicule::find($vehicule);
      if($vehiculeFinded == null) return $this->sendError('No existe el cliente igresado.');

      $vehiculeFinded->state = 'deleted';
      $vehiculeFinded->save();
      $vehiculeFinded->delete();
      return $this->sendResponse($vehiculeFinded,'Vehiculo eliminado existosamente.');
    }



    public function restore($vehicule)
    {
      // code...
      if(!is_numeric($vehicule)) return $this->sendError('Parametro no valido.');
      $vehiculeFinded = Vehicule::withTrashed()->find($vehicule);
      if($vehiculeFinded->state == 'active') return $this->sendError('El vehiculo se encuentra activo.');
      $vehiculeFinded->state = 'active';
      $vehiculeFinded->save();
      $vehiculeFinded->restore();
      return $this->sendResponse($vehiculeFinded,'Vehiculo recuperado existosamente.');


    }


}
