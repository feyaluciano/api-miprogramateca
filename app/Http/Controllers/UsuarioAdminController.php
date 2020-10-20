<?php

namespace App\Http\Controllers;

use App\UsuarioAdmin;
use Illuminate\Http\Request;

class UsuarioAdminController extends Controller
{




    public function loginadmin(Request $request) {
        $user = new UsuarioAdmin;
        $user = Usuario::where('email', $request->email)->first();
        if ($user != null) 
            return response()->json(array('success' => true, 'user' => $user), 200);	
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
     * @param  \App\UsuarioAdmin  $usuarioAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(UsuarioAdmin $usuarioAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UsuarioAdmin  $usuarioAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(UsuarioAdmin $usuarioAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UsuarioAdmin  $usuarioAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsuarioAdmin $usuarioAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UsuarioAdmin  $usuarioAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsuarioAdmin $usuarioAdmin)
    {
        //
    }
}
