<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\TokensController;
use Illuminate\Http\Request;
use Exception;

class ControlAccesoPorToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        try {           
            $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
            $tc->validarToken($request);//INTENTO DECODIFICAR SI DA ERROR VA AL CATCH Y REDIRIGE AL HOME           
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildarCx'               
            ], 422);
        }

        
    //    $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
    //    try {
    //         $tc->validarToken($request->token);//INTENTO DECODIFICAR SI DA ERROR VA AL CATCH Y REDIRIGE AL HOME
    //         return $next($request);
    //     }
    //     catch (Exception $e ) {
    //         echo $e->getmessage();
           
    //     }
        
        
    }
}
