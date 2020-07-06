<?php

namespace App\Http\Controllers\Access;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class AccessDeniedController extends ApiController
{
    public function notAdmin()
    {
      return $this->sendError('Acceso no permitido por privilegios');
    }
    public function notAccess()
    {
      return $this->sendError('Acceso no permitido.');
    }
}
