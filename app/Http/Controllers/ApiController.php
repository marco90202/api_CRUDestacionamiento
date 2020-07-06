<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

class ApiController extends Controller
{

    /**
     *  Esta función retorna mensaje estandarizado de solicitud exitosa al cliente que se encuentre logeado
     */
    public function sendAuthResponse($result, $request, $message = 'Success'){
        $response = [
            'success' => true,
            // 'results' => $result !== null ? sizeof($result ): 'Es nulo',
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    /**
     *  Esta función retorna mensaje estandarizado de solicitud exitosa al cliente
     */
    public function sendResponse($result, $message = 'Success'){
        $response = [
            'success' => true,
            // 'results' => $result !== null ? sizeof($result ): 'Es nulo',
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, 200);
    }

    /**
     *  Esta función retorna mensaje estandarizado de solicitud exitosa al cliente
     */
    public function sendResponseSistemas($response, $request){

        $this->insertLog($request, 200, null);
        return response()->json($response, 200);
    }

    /*
     *  Esta función retorna mensaje estandarizado de solicitud fallida del cliente que se encuentre logeado
     */
    public function sendAuthError($error, $request, $errorMessages = [], $code = 404){
        $response = [
            'success' => false,
            'error' => $error,
            'errorMessages' => $errorMessages
        ];
        sizeof($errorMessages) == 0 ? $errorMessages = [$error] : null;
        return response()->json($response, $code);
    }

    /*
     *  Esta función retorna mensaje estandarizado de solicitud fallida del cliente
     */

    public function sendError($error, $errorMessages = [], $code = 404){
        $response = [
            'success' => false,
            'error' => $error,
            'errorMessages' => $errorMessages
        ];
        return response()->json($response, $code);
    }

    /*
     *  Esta función retorna mensaje estandarizado de solicitud fallida del cliente
     */

    public function sendErrorSistemas($message, $request,$user_id){
      $response = [
        'success' => false,
        'user_id' => $user_id,
        'valor' => 1,
        'message' => $message
      ];
        $this->insertLog($request, 404, null);
        return response()->json($response, 404);
    }

    public function parseXMLtoArray($response)
    {
      $ejemplo = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><RegistrarParticipanteExternoResponse xmlns="http://tempuri.org/"><RegistrarParticipanteExternoResult><Valor>0</Valor><Mensaje>OK</Mensaje><cPersona>7501415</cPersona><idUsuarioEC>6</idUsuarioEC></RegistrarParticipanteExternoResult></RegistrarParticipanteExternoResponse></soap:Body></soap:Envelope>';

      $ejemplo2 = '<aaaa Version="1.0">
                   <bbb>
                     <cccc>
                       <dddd Id="id:pass" />
                       <eeee name="hearaman" age="24" />
                     </cccc>
                   </bbb>
                </aaaa>';

      $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", '$1$2$3', $response);
      $xml = simplexml_load_string($xml);
      $json = json_encode($xml);
      $responseArray = json_decode($json,true);
      // dd($responseArray);
      return $responseArray;
    }

    /*
    * Autor: Daniel P.
    * Retorna cadena tipo slug para ser legible como url o path de servidor
    */

    public function cleanName($name)
    {
      return str_slug(trim($name));
    }

    /*
    * Autor: Daniel P.
    * Retorna cadena limpia para vista de usuario
    * sin caracteres especiales, pero muestra tildes, ñ y espacios
    */

    public function cleanNameVisible($name)
    {
      return preg_replace('([^A-Za-z0-9-_[:space:] áéíóúÁÉÍÓÚñÑ])', '', trim($name));
    }

    public function realtime()
    {
        $now = new \DateTime();
        $now->modify('-5 hours');
        return $now;
    }

    // public function insertLog($endpoint, $method, $controller, $user_id, $body=null, $url=null)
    // {
    //   $event = new EventLog();
    //   $event->endpoint = $endpoint;
    //   $event->method = $method;
    //   $event->body = $body;
    //   $event->controller = $controller;
    //   $event->url = $url;
    //   $event->author_id = $user_id;
    //   $event->save();
    // }

    public function insertAuthLog($request, $statusCode = null, $errors = null)
    {
      // dd($request->header('User-Agent'));
        $event = new EventLog();
        $event->endpoint = $request->path();
        $event->method = $request->method();
        $event->status_code = $statusCode;
        $event->error_detail = $errors !== null ? json_encode($errors) : null;
        $event->body = $request->method() !== 'GET' ? json_encode($request->all()) : null;
        $event->agent = $request->header('User-Agent');
        $event->url = $request->fullUrl();
        $event->author_id = Auth::user()->id;
        $event->save();
    }

    public function insertLog($request, $statusCode = null, $errors = null)
    {
      // dd($request->header('User-Agent'));
        $event = new EventLog();
        $event->endpoint = $request->path();
        $event->method = $request->method();
        $event->status_code = $statusCode;
        $event->error_detail = $errors !== null ? json_encode($errors) : null;
        $event->body = $request->method() !== 'GET' ? json_encode($request->all()) : null;
        $event->agent = $request->header('User-Agent');
        $event->url = $request->fullUrl();
        $event->author_id = null;
        $event->save();
    }

}
