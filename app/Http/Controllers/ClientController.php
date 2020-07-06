<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Client;

class ClientController extends ApiController
{
    //
    public function index()
    {
      // code...
      $clients = Client::where('state','active')->get();

      return $this->sendResponse($clients,'Clientes activos');
    }


    public function show($client, Request $request)
    {
      // code...
      if(!is_numeric($client)) return $this->sendError('Parametro debe ser numerico.');

      $clientFinded = Client::find($client);
      if($clientFinded == null) return $this->sendError('No existe el cliente igresado.');

      return $this->sendResponse($clientFinded, 'Informacion del usuarios.');
    }



    public function store(Request $request)
    {
      //dd($request->all());
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:clients,email|string',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ]);

        if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);

        $client = new Client();
        $client->firstname = $request->firstname;
        $client->lastname = $request->lastname;
        $client->email = $request->email;
        $client->password = $request->password;
        $client->save();

        return $this->sendResponse($client, 'Cliente creado existosamente.');

    }




    public function update($client, Request $request)
    {
      // code...
      if(!is_numeric($client)) return $this->sendError('Parametro debe ser numerico.');

      $clientFinded = Client::find($client);
      if($clientFinded == null) return $this->sendError('No existe el cliente igresado.');

      $validator = Validator::make($request->all(), [
          'firstname' => 'nullable|string',
          'lastname' => 'nullable|string',
          'email' => 'nullable|email|unique:clients,email|string'
      ]);
      if($validator->fails()) return $this->sendError($validator->errors(),'Error en la validacion',422);

      $data = $request->input();

      if(sizeof($data) > 0){
        $clientFinded->fill($data)->save();
        $msg = 'Se actualizó la información del cliente: '.$clientFinded->lastname.', '.$clientFinded->firstname;

      }else{
        $msg = 'No se pudo actualizar la información del cliente: '.$clientFinded->lastname.', '.$clientFinded->firstname;
      }

      return $this->sendResponse($clientFinded,$msg);

    }






    public function destroy($client)
    {
      // code...
      if(!is_numeric($client)) return $this->sendError('Parametro no valido.');
      $clientFinded = Client::find($client);
      if($clientFinded == null) return $this->sendError('No existe el cliente igresado.');

      $clientFinded->state = 'deleted';
      $clientFinded->save();
      $clientFinded->delete();
      return $this->sendResponse($clientFinded,'Cliente eliminado existosamente.');
    }



    public function restore($client)
    {
      // code...
      if(!is_numeric($client)) return $this->sendError('Parametro no valido.');
      $clientFinded = Client::withTrashed()->find($client);
      if($clientFinded->state == 'active') return $this->sendError('El cliente se encuentra activo.');
      $clientFinded->state = 'active';
      $clientFinded->save();
      $clientFinded->restore();
      return $this->sendResponse($clientFinded,'Cliente recuperado existosamente.');


    }

}
