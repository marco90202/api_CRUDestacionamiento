<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;
use \Laravel\Passport\Http\Controllers\AccessTokenController;
use Auth;
use DB;
use Validator;
use App\Client;
use App\User;

class AccessController extends AccessTokenController
{
    public function loginazo(ServerRequestInterface $request)
    {
        $success = false;
        $state = 404;
        $isStudent = true;

        // para el log

        try {
            $tokenResponse = parent::issueToken($request);
            $token = $tokenResponse->getContent();

            // Convert json to array
            $data = json_decode($token, true);
            // dd($data);
            // $tokenInfo will contain the usual Laravel Passport token response.
            $tokenInfo = json_decode($token, true);
            if(!isset($data['error'])){
                // Then we just add the user to the response before returning it.
                $username = $request->getParsedBody()['username'];
                $user = User::where('email',$username)->where('state','=','active')->first();

                /* Se valida que el usuario tenga como estado "registrado" (obligatorio); es decir, no haya sido eliminado,
                de lo contrario, no se le permite el acceso */

                if($user === null) return $this->sendError('Usuario sin registro activo');


                $tokenInfo = collect($tokenInfo);
                $tokenInfo->put('user', $user);
                // Pendiente puttear navegaciones, roles
                $success = true;
                $state = 200;
            }
            //insertar aqui en tabla request
            // $this->storeAccess($user->id, $request->getParsedBody());
            // $userRequest = new UserRequest;
            // $userRequest->endpoint =
            $response = [
                'success' => $success,
                'data' => $tokenInfo //agregar objeto navigationbar
            ];
            // return response()->json($response, $state);
            return $this->sendResponse($tokenInfo);


        } catch (Exception $e) {
            $response = [
                'success' => $success,
                'message' => 'Internal server error'
            ];
            //return response()->json($response, 500);
            return $this->sendResponse($response);

        }
    }

     public function register (Request $request)
     {
       // para el log
       //$bodyLog = $request->all();
       //unset($bodyLog['password'],$bodyLog['confirm_password']);

       // dd($request->server()['REQUEST_METHOD']);
         $validator = Validator::make($request->all(), [
             'firstname' => 'required',
             'lastname' => 'required',

             // 'lastname' => 'required',
             // 'gender_id' => 'required|integer',
             // 'role_id' => 'required|integer|min:2|max:3',
             'email' => 'required|email|unique:users,email',
             'password' => 'required',
             'confirm_password' => 'required|same:password'
         ]);

         if( $validator->fails() ){
             return $this->sendError($validator->errors(),'Error de validación de datos.', 422);
         }

         // Si no hay errores del cliente se registra

         //$input = $request->all();
         $input = [];
         $input['firstname'] = $request->get('firstname');
         $input['lastname'] = $request->get('lastname');
         $input['email'] = $request->get('email');
         $input['password'] = bcrypt($request->get('password'));

          //dd($input);
         $user = User::create($input);
         $token = $user->createToken('CRUD')->accessToken;

         $data = [
                     //'token' => $token,
                      $user
                 ];
         return $this->sendResponse($data,'Registro satisfactorio.');
     }

    /**
     *  Esta función retorna mensaje estandarizado de solicitud exitosa al cliente
     */
    protected function sendResponse($result, $message = 'Success' ){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    /**
     *  Esta función retorna mensaje estandarizado de solicitud fallida del cliente
     */
    protected function sendError($error, $errorMessages = [], $code = 404){

        $response = [
            'success' => false,
            'error' => $error,
            'errorMessages' => $errorMessages
        ];
        return response()->json($response, $code);
    }

    public function insertAuthLog($request, $bodyLog, $statusCode = null)
    {
        $event = new EventLog();
        $event->endpoint = $request['REQUEST_URI'];
        $event->method = 'POST';
        $event->status_code = $statusCode;
        $event->body = json_encode($bodyLog);
        $event->url = $request['REQUEST_URI'];
        $event->save();
    }



}
