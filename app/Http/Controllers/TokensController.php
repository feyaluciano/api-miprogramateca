<?php

namespace App\Http\Controllers;

use App\Usuario;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use Validator;



class TokensController extends Controller
{

    public function validarToken(Request $request)
    {
        $arr=$request->header()["authorization"];
        $token = explode(" ",$arr[0])[1];
        $key='example_key';
        try {
            
            $decoded = JWT::decode(json_decode($token), $key, array('HS256'));

        return response()->json([
            'success' => true,              
            'message' => 'Registrado'
           // 'errors' => $validator->errors()
        ], 200);


        
        }
        catch( Exception $e ){
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildaree',
                'errors' => $e->getMessage
            ], 422);

        }
        //echo $decoded;

    }
    public function login(Request $request)
    {
        $key = "example_key";      //ESTA CLAVE ALOJARLA EN .ENV Y TOMARLA DE AHI
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);//CONFIGURO LA VALIDACIÓN

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'code' => 1,
        //         'message' => 'Error al valildar',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar',
                'errors' => $validator->errors()
            ], 422);
        }      
        $user = Usuario::Where('Email', $request->email)->Where('Password', $request->password)->first();
        //SI LA VALIDACION PASA, BUSCO EN LA bd ESE EMAIL Y PASS, SI SE ENCUENTRA GENERO EL TOKEN    
        if ($user != null) {             
            //$time=date('His');
            $time=time();
            //echo $time;
            $expTime =$time * 60 * 60;//una hora
            $payload = array(
                "name" => $user->Nombre,
                "email" => $user->Email,
                "iss" => "lucianoferrari.com.ar",//QUIEN ENTREGO EL TOKEN
                "exp" => $expTime,//MOMENTO QUE EXPIRA EL TOKEN
                "iat" => $time,//MOMENTO EN EL QUE FUE EMITIDO
                "nbf" => $time//A PARTIR DE ESTE MOEMNTO EL TOKEN ES VALIDO
               //"isat" =>0,
               //"nsdbf" => 0
            );
            
           
            $token = JWT::encode($payload, $key);      
            return response()->json([
                'success' => true,
                'token' => $token,
               'user' => $user //EL USER NO LO ENVIO EN LA RESPUESTA, SI QUIERE ESA INFO DEBERIA DESENCRIPTAR EL TOKEN,
               // O TAMBIEN PODRIA MANDARLA PARA MAS SIMPLICIDAD               
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Usuario o password incorrectos'.$request->password,
                'errors' => $validator->errors()], 401);
        }
        return $jwt;
    }



    public function loginadmin(Request $request)
    {
        $key = "example_key";      //ESTA CLAVE ALOJARLA EN .ENV Y TOMARLA DE AHI
        $credentials = $request->only('email', 'password');
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);//CONFIGURO LA VALIDACIÓN

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'code' => 1,
        //         'message' => 'Error al valildar',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar',
                'errors' => $validator->errors()
            ], 422);
        }      
        $user = Usuario::Where('Email', $request->email)->Where('Password', $request->password)->first();
        //SI LA VALIDACION PASA, BUSCO EN LA bd ESE EMAIL Y PASS, SI SE ENCUENTRA GENERO EL TOKEN    
        if ($user != null) {             
            //$time=date('His');
            $time=time();
            //echo $time;
            $expTime =$time * 60 * 60;//una hora
            $payload = array(
                "name" => $user->Nombre,
                "email" => $user->Email,
                "iss" => "lucianoferrari.com.ar",//QUIEN ENTREGO EL TOKEN
                "exp" => $expTime,//MOMENTO QUE EXPIRA EL TOKEN
                "iat" => $time,//MOMENTO EN EL QUE FUE EMITIDO
                "nbf" => $time//A PARTIR DE ESTE MOEMNTO EL TOKEN ES VALIDO
               //"isat" =>0,
               //"nsdbf" => 0
            );
            
           
            $token = JWT::encode($payload, $key);      
            return response()->json([
                'success' => true,
                'token' => $token,
               'user' => $user //EL USER NO LO ENVIO EN LA RESPUESTA, SI QUIERE ESA INFO DEBERIA DESENCRIPTAR EL TOKEN,
               // O TAMBIEN PODRIA MANDARLA PARA MAS SIMPLICIDAD               
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'code' => 2,
                'message' => 'Usuario o password incorrectos'.$request->password,
                'errors' => $validator->errors()], 401);
        }
        return $jwt;
    }










}
