<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var User|null Usuário autenticado */
    protected $usuario;

    public function __construct()
    {
        if(JWTAuth::getToken()) {
            $this->usuario = JWTAuth::parseToken()->authenticate();
        }
    }
}
