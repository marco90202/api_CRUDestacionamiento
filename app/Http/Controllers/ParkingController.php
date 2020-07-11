<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parking;
use Validator;

class ParkingController extends ApiController
{
    //
    public function index()
    {
      // code...
      $parking = Parking::where('state','active')->get();

      return $this->sendResponse($parking,'Estacionamientos activos.');

    }


    public function show($parking, Request $request)
    {
      // code...
      if(!is_numeric($parking)) return $this->sendError('Parametro debe ser numerico.');

      $parkingFinded = Parking::find($parking);
      if($parkingFinded == null) return $this->sendError('No existe el estacionamiento igresado.');

      return $this->sendResponse($parkingFinded, 'Informacion del estacionamiento.');
    }




    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'place' => 'required|string',
            'level' => 'required|string',
            'status' => 'required|string',
            'vehicule_id' => 'required|integer'
        ]);

        if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);

        $parking = new Parking();
        $parking->place = $request->place;
        $parking->level = $request->level;
        $parking->status = $request->status;
        $parking->vehicule_id = $request->vehicule_id;
        $parking->save();

        return $this->sendResponse($parking, 'Estacionamiento asignado existosamente.');

    }




    public function update($parking, Request $request)
    {
      // code...
      if(!is_numeric($parking)) return $this->sendError('Parametro debe ser numerico.');

      $parkingFinded = Parking::find($parking);
      if($parkingFinded == null) return $this->sendError('No existe el estacionamiento igresado.');

      if($parkingFinded->plate == $request->plate){
        $validator = Validator::make($request->all(), [
          'place' => 'nullable|string',
          'level' => 'nullable|string',
          'status' => 'nullable|string',
          'vehicule_id' => 'nullable|integer'

        ]);
        if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);
          $data = $request->input();
      }else{
        $validator = Validator::make($request->all(), [
          'place' => 'nullable|string',
          'level' => 'nullable|string',
          'status' => 'nullable|string',
          'vehicule_id' => 'nullable|integer'
        ]);
        if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);
        $data = $request->input();
      }

      if(sizeof($data) > 0){
        $parkingFinded->fill($data)->save();
        $msg = 'Se actualizó la información del estacionamiento.';

      }else{
        $msg = 'No se pudo actualizar la información del estacionamiento.';
      }

      return $this->sendResponse($parkingFinded,$msg);

    }






    public function destroy($parking)
    {
      // code...
      if(!is_numeric($parking)) return $this->sendError('Parametro no valido.');
      $parkingFinded = Parking::find($parking);
      if($parkingFinded == null) return $this->sendError('No existe el estacionamiento igresado.');

      $parkingFinded->state = 'deleted';
      $parkingFinded->save();
      $parkingFinded->delete();
      return $this->sendResponse($parkingFinded,'estacionamiento eliminado existosamente.');
    }



    public function restore($parking)
    {
      // code...
      if(!is_numeric($parking)) return $this->sendError('Parametro no valido.');
      $parkingFinded = Parking::withTrashed()->find($parking);
      if($parkingFinded->state == 'active') return $this->sendError('El estacionamiento se encuentra activo.');
      $parkingFinded->state = 'active';
      $parkingFinded->save();
      $parkingFinded->restore();
      return $this->sendResponse($parkingFinded,'Estacionamiento recuperado existosamente.');


    }
}
