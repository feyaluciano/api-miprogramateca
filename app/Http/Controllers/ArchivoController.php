<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\DB;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     
    }



    public function subirImagen(Request $request)
    {    
        $image = $request->Imagen;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        //return $image; 
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(5).'.'.'png';
        \File::put(storage_path(). '/' . $imageName, base64_decode($image));   
    }
  
     
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {        
       
    }



   


    public function show(TipoRecurso $tipoRecurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoRecurso $tipoRecurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoRecurso $tipoRecurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoRecurso $tipoRecurso)
    {
        //
    }
}
