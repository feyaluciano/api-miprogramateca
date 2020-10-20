<?php

namespace App\Http\Controllers;

use App\TipoRecurso;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\DB;

class TipoRecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //$tiporecursos = \App\TipoRecurso::all();   
		//$tiporecursos = DB::table('tiposrecursos')->where('Activo','=', '1')->get();	
$tiposrecursos = \App\TipoRecurso::where('Activo','=','1')->get();	

foreach($tiposrecursos as $tiporecu) {
   // $tiporecu->NombreTipoRecurso = utf8_decode($tiporecu->NombreTipoRecurso);
    $tiporecu->ImagenBase64 = "";
}


		return $tiposrecursos;
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
        try {           
            $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
            $tc->validarToken($request);//INTENTO DECODIFICAR SI DA ERROR RETORNO ERROR SINO SIGO CON EL METODO        
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar'               
            ], 422);
        }


       
		
        $tiporecurso = new TipoRecurso;
        //Declaramos el nombre con el nombre enviado en el request
        $tiporecurso->NombreTipoRecurso = $request->NombreTipoRecurso;
		$recurso->Descripcion = $request->Descripcion;
		$tiporecurso->Imagen = $request->Imagen;
		$tiporecurso->Color = $request->Color;
		$tiporecurso->Cantidad = $request->Cantidad;		
		$tiporecurso->Activo = $request->Activo;        
        //Guardamos el cambio en nuestro modelo
        if ($tiporecurso->save()) {
			return response()->json(array('success' => true, 'last_insert_id' => $tiporecurso->IdTipoRecurso), 200);			
		} else {
			return response()->json(array('success' => false, 'last_insert_id' => 0), 500);	
		}
    }



    public function storeObjetoCompleto(Request $request)
    {     
        
        $log="";   
        try {           
            $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
            $tc->validarToken($request);//INTENTO DECODIFICAR SI DA ERROR RETORNO ERROR SINO SIGO CON EL METODO        
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar'               
            ], 422);
        }                
        if ($request->IdTipoRecurso==0){
            $log.="entroooo nuevoo";
            //SI EL ID DEL OBJETO ES 0, VOY A INSERTAR CREO UN RECURSO                              
            $tiporecurso = new TipoRecurso;             
        } else {      
            $log.="entroooo editar";                 
            $tiporecurso = TipoRecurso::findOrFail($request->IdTipoRecurso); 
            //$tiporecurso->IdTipoRecurso = utf8_encode($request->IdTipoRecurso);
        } 
                
        //TOMO LOS CAMPOS RECIBIDOS EN EL REQUEST Y CARGO EL OBJETO, LUEGO LO GUARDO
        $tiporecurso->NombreTipoRecurso = $request->NombreTipoRecurso;
           
        $tiporecurso->Descripcion = $request->Descripcion;
      
        $tiporecurso->Imagen = $request->Imagen;
        
        $tiporecurso->ImagenBase64 = $request->ImagenBase64;

		$tiporecurso->Color = $request->Color;
		$tiporecurso->Cantidad = $request->Cantidad;		
		$tiporecurso->Activo = $request->Activo;         
         //Guardamos el cambio en nuestro modelo
         if ($tiporecurso->save()) {
             
             return response()->json(array( $log.'success' => true, 'last_insert_id' => $tiporecurso->IdTipoRecurso), 200);			
         } else {
            return false;
             return response()->json(array($log.'ERROR' => false, 'last_insert_id' => 0), 500);	
         }
          
    }









    /**
     * Display the specified resource.
     *
     * @param  \App\TipoRecurso  $tipoRecurso
     * @return \Illuminate\Http\Response
     */






    


    public function buscar(Request $request)
    {       
        $cantidadPorPagina=10; 
        $page=$request->page;
        
        try {           
            $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
            $tc->validarToken($request);//INTENTO DECODIFICAR SI DA ERROR RETORNO ERROR SINO SIGO CON EL METODO        
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar'               
            ], 422);
        }  
        
        $tiposrecursos=[];

       
        
        //SI NO ESTOY BUSCANDO
        $logRetorno="";
        if (($request->OpcionBusquedaUno=="") ) {
            $logRetorno="Sin busqueda";
            $tiposrecursos = TipoRecurso::skip($cantidadPorPagina*$page)->take($cantidadPorPagina)->get();
            //$cantidad= TipoRecurso->get()->count();
            $cantidad = \App\TipoRecurso::all()->count();       

        }
        else {
           // $tiposrecursos = TipoRecurso::all();
           $tiposrecursos= DB::table('tiposrecursos');


            if ($request->OpcionBusquedaUno=="pornombretipo") {               
                    $buscar="%".$request->NombreTipoRecurso."%";
                    $logRetorno.="con busquqeda nombret".$buscar;                    
                    $tiposrecursos =$tiposrecursos->where('NombreTipoRecurso', 'like','%'.$buscar.'%')->get();                    
              }

             

              $cantidad=count($tiposrecursos);


              $totalE=($cantidadPorPagina*$page)  + $cantidadPorPagina;
              //$tiposrecursos=$tiposrecursos->orderBy('NombreTipoRecurso','asc')->skip($cantidadPorPagina*$page)->take($cantidadPorPagina)->get();
              
    }
    



        foreach($tiposrecursos as $tiporecu) {			
           // $tiporecu->NombreTipoRecurso = utf8_decode($tiporecu->NombreTipoRecurso);			
        }
        



         if (count($tiposrecursos) > 0 )  {
             return response()->json(array( $logRetorno.'success' => true, 'data' => $tiposrecursos,'total' => $cantidad), 200);			
         } else {
             return response()->json(array('success' => false, 'data' => 0), 500);	
         }
          
    }





    public function getPorId(Request $request)
    {
        $tiposrecursos = DB::table('tiposrecursos')->where('IdTipoRecurso', $request->IdTipoRecurso)->get();
        foreach($tiposrecursos as $tiporecu) {
            $tiporecu->NombreTipoRecurso = utf8_decode($tiporecu->NombreTipoRecurso);
        }
        return $tiposrecursos;
    }



    public function cambiarDeEstado(Request $request)
    {
        try {           
            $tc=new TokensController();//INSTANCIO EL CONTROLLER QUE MANEJO LOS TOKENS
            $tc->validarToken($request);//INTENTO DECODIFICAR SI DA ERROR RETORNO ERROR SINO SIGO CON EL METODO        
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error al valildar'               
            ], 422);
        }                


        $selec=$this->getPorId($request)[0];
        $estadoActual=$selec->Activo;
        $nuevoEstado=!$estadoActual;


        try {                                                                
        DB::table('tiposrecursos')
        ->where('IdTipoRecurso', $request->IdTipoRecurso)
        ->update(['Activo' => $nuevoEstado]);

        return response()->json(array( 'success' => true, 'update_id' => $request->IdTipoRecurso), 200);	
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error ale eliminar'.$e               
            ], 422);
        }            
    }



    public function getTipoRecursoPorId(Request $request)
    {
        //$recursos = DB::table('recursos')->where('IdRecurso', $request->IdRecurso)->get();
        $tiposrecursos = TipoRecurso::where('IdTipoRecurso', $request->IdTipoRecurso)->get();
        foreach($tiposrecursos as $tiporecu) {
            $tiporecu->NombreTipoRecurso = utf8_decode($tiporecu->NombreTipoRecurso);			
        }
        return $tiposrecursos;
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
