<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MensajeDeBienvenida;

class UsuarioController extends Controller
{



    public function registro(Request $request)
    {
		
        $usuario = new Usuario;
        //Declaramos el nombre con el nombre enviado en el request
        $usuario->Email = $request->email;
        $usuario->Password = $request->password;
        $usuario->Apellido = $request->apellido;
        $usuario->Nombre = $request->nombre;
		$usuario->Activo = 0;
		
        if ($usuario->save()) {
            
           //return Mail::to($usuario->Email)->send(new MensajeDeBienvenida("Bienvenido ".$usuario->Nombre." ".$usuario->Apellido));
        
           $confirmation_code= str_random(25);
           $para      = 'feyaluciano@gmail.com';
           $titulo    = 'Bienvenido a Mi Programateca';
        //https://programacionymas.com/blog/confirmar-email-laravel
           $mensaje="";
           $mensaje.= "<html>\n";
           $mensaje.= "<head></head>\n";
           $mensaje.= "<body>\n";
           $mensaje.= "Bienvenido a Mi Programateca, espero puedas encontrar algo que te sea útil en mi página.\n";
            $mensaje.="<p>Para ello simplemente debes hacer click en el siguiente enlace:</p><a href='/auth/validaremail/" . $confirmation_code."'>Clic para confirmar tu email</a>";

           $mensaje.= "</body>\n";
           // some PHP code here …
           $mensaje.= "</html>\n";
           $mensaje.= "\n";
           
           $cabeceras = 'From: miprogramateca@lucianoferrari.com.ar' . "\r\n" .
               'Reply-To: feyaluciano@gmail.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
           
            //mail($para, $titulo, $mensaje, $cabeceras);

        
            return response()->json(array('success' => true, 'last_insert_id' => $usuario->IdUsuario), 200);			
        
        
        
        } else {
			return response()->json(array('success' => false, 'last_insert_id' => 0), 500);	
		}
    }

    public function login(Request $request) {
        $user = new Usuario;
        $user = Usuario::where('email', $request->email)->first();
        if ($user != null) 
            return response()->json(array('success' => true, 'user' => $user), 200);	
            else {
                return response()->json(array('success' => "false".$request->email."llega", 'user' => $user), 200);	
            }
    }


    public function chequearEmail(Request $request) {
        $user = new Usuario;
        $user = Usuario::where('email', $request->email)->first();
        if ($user != null) 
            return response()->json(array('noEsEmailDisponible' => true), 200);	
            else {
                return response()->json(null, 200);	
            }
    }

    public function validarEmail(Request $request) {
        $user = new Usuario;
        $user = Usuario::where('codigoValidacion', $request->codigoValidacion)->first();



        if ($user != null) {
            $user->confirmado = true;
            $user->codigo_confirmacion = null;
            $user->save();
            return response()->json(array('success' => true, 'user' => $user), 200);	
        }
            else {
                return response()->json(array('success' => "false".$request->email."llega", 'user' => $user), 200);	
            }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
