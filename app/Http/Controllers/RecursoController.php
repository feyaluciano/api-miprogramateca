<?php

namespace App\Http\Controllers;

use App\TipoRecurso;
use App\Recurso;
use Illuminate\Http\Request;
use DB;


class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$recursos = \App\Recurso::all();       
		return $recursos;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPorId(Request $request)
    {
        $recursos = DB::table('recursos')->where('IdTipoRecurso', $request->IdTipoRecurso)->get();
        foreach($recursos as $recu) {
            $recu->Titulo = utf8_decode($recu->Titulo);
        }
        return $recursos;
    }
	
	
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecursoPorId(Request $request)
    {
        //$recursos = DB::table('recursos')->where('IdRecurso', $request->IdRecurso)->get();
        $recursos = Recurso::with('tiporecurso')->where('IdRecurso', $request->IdRecurso)->get();
        foreach($recursos as $recu) {
            $recu->Titulo = utf8_decode($recu->Titulo);
			$recu->CuerpoRecurso = utf8_decode($recu->CuerpoRecurso);
        }
        return $recursos;
    }


    public function getRecursos(Request $request)
    {
        //where('Activo', true)->
        //$recursos = Recurso::with('tiporecurso')->orderBy('fechaCreacion','desc');
        $recursos = Recurso::where('FechaBaja', '=',null)->with('tiporecurso')->orderBy('fechaCreacion','desc')->get();
               
        //$recursos = DB::table('recursos')->where('Activo', true)->get();
        foreach($recursos as $recu) {
            $recu->IdRecurso = utf8_decode($recu->idRecurso);
            $recu->Titulo = utf8_decode($recu->Titulo);
            $recu->CuerpoRecurso = utf8_decode($recu->CuerpoRecurso);
            


            
        }
        return $recursos;
    }


    public function getRecursosPaginado(Request $request)
    {
        //RECIBO EL NUMERO DE PAGINA 
        $page=$request->page;      
        
        //OBTENGO LA CANTIDAD TOTAL PARA USAR EN LA PAGINACION ANGULAR
        $cantidad=Recurso::where('FechaBaja', '=',null)->get()->count();

        //YO DEFINI LA PAGINACION DE A 10 ELEMENTOS, POR ESO, SALTEO LOS 10 ELEMENTOS EMPEZANDO DE LA PAGINA -1 Y TOMO 10
        $recursos = Recurso::where('FechaBaja', '=',null)->with('tiporecurso')->orderBy('fechaCreacion','desc')->skip(10*$page)->take(10)->get();
               
        //$recursos = DB::table('recursos')->where('Activo', true)->get();
        foreach($recursos as $recu) {
            $recu->IdRecurso = utf8_decode($recu->idRecurso);
            $recu->Titulo = utf8_decode($recu->Titulo);
            $recu->CuerpoRecurso = utf8_decode($recu->CuerpoRecurso);                        
        }
        return response()->json([
            'data' => $recursos,              
            'total' => $cantidad               
        ],200);

        //return $recursos;
    }


    
    
    public function getUltimosRecursos()
    {

        //$recursos = DB::table('recursos')->orderBy('created_at','desc')->take(10)->get();
		
		//$recursos = Recurso::where('IdRecurso', '>', '1');
		
		$search="a";
		$recursos = Recurso::with('tiporecurso')->where('FechaBaja', '=',null)->orderBy('fechaCreacion','desc')
                ->paginate(10);		  	
        foreach($recursos as $recu) {			
            $recu->Titulo = utf8_decode($recu->Titulo);
			$recu->CuerpoRecurso = utf8_decode($recu->CuerpoRecurso);
        }
        return $recursos;

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

		
        $recurso = new Recurso;
        //Declaramos el nombre con el nombre enviado en el request
        $recurso->Titulo = $request->Titulo;
		$recurso->TituloUrl = $request->TituloUrl;
		$recurso->CuerpoRecurso = $request->CuerpoRecurso;
		$recurso->Recomendado = $request->Recomendado;
		$recurso->IdUsuario = $request->IdUsuario;
		$recurso->IdTipoRecurso = $request->IdTipoRecurso;
		$recurso->Activo = $request->Activo;
        $recurso->Oculto = $request->Oculto;
       
        //Guardamos el cambio en nuestro modelo
        if ($recurso->save()) {
			return response()->json(array('success' => true, 'last_insert_id' => $recurso->IdRecurso), 200);			
		} else {
			return response()->json(array('success' => false, 'last_insert_id' => 0), 500);	
		}
    }



    public function totalesPanel(){
        $totales=[];
        $countR = \DB::table('recursos')->where('FechaBaja', '=', null)->count();

        $countTR = \DB::table('tiposrecursos')->where('Activo', '=', 1)->count();

        $totales[0]=$countR;
        return response()->json(array( 'success' => true, 'cantRecursos' => $countR, 'cantTRecursos' => $countTR), 200);


    }




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
        
        $recursos=[];

       
        
        //SI NO ESTOY BUSCANDO
        $logRetorno="";
        if (($request->OpcionBusquedaUno=="") && ($request->OpcionBusquedaDos=="")) {
            $logRetorno="Sin busqueda";
            $recursos = Recurso::where('FechaBaja', '=',null)->with('tiporecurso')->orderBy('fechaCreacion','desc')->skip($cantidadPorPagina*$page)->take($cantidadPorPagina)->get();
            $cantidad= Recurso::where('FechaBaja', '=',null)->get()->count();
        }
        else {



            $recursos = Recurso::where('FechaBaja', '=',null)->with('tiporecurso');

             if ($request->OpcionBusquedaUno=="portitulo") {               
                    $buscar="%".$request->Titulo."%";
                    $logRetorno.="con busquqeda porti".$buscar;                    
                    $recursos =$recursos->where('Titulo', 'like','%'.$buscar.'%');                    
              }

              if ($request->OpcionBusquedaDos=="portipor") {                              
                $logRetorno.="con busquqeda tipo".$request->IdTipoRecurso;                    
                $recursos =$recursos->where('IdTipoRecurso', '=',$request->IdTipoRecurso);                    
              }

              $cantidad=count($recursos->get());


              $totalE=($cantidadPorPagina*$page)  + $cantidadPorPagina;
  
                $recursos=$recursos->orderBy('fechaCreacion','desc')->skip($cantidadPorPagina*$page)->take($cantidadPorPagina)->get();            
    }
    



        foreach($recursos as $recu) {			
            $recu->Titulo = utf8_decode($recu->Titulo);
			$recu->CuerpoRecurso = utf8_decode($recu->CuerpoRecurso);
        }
        



         if (count($recursos) > 0 )  {
             return response()->json(array( $logRetorno.'success' => true, 'data' => $recursos,'total' => $cantidad), 200);			
         } else {
             return response()->json(array('success' => false, 'data' => 0), 500);	
         }
          
    }






    public function storeObjetoCompleto(Request $request)
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
        if ($request->idRecurso==0){
            //SI EL ID DEL OBJETO ES 0, VOY A INSERTAR CREO UN RECURSO            
            $now = new \DateTime();            
            $recurso = new Recurso; 
            $recurso->Recomendado=false;
            $recurso->FechaBaja=null;
            $recurso->FechaCreacion=$now->format('Y-m-d H:i:s');
        } else {                        
            $recurso = Recurso::findOrFail($request->idRecurso); 
            $recurso->IdRecurso = utf8_encode($request->idRecurso);
        }            
        //TOMO LOS CAMPOS RECIBIDOS EN EL REQUEST Y CARGO EL OBJETO, LUEGO LO GUARDO
        $recurso->Titulo = utf8_encode($request->Titulo);
		$recurso->TituloUrl = utf8_encode($request->TituloUrl);
		$recurso->CuerpoRecurso = utf8_encode($request->CuerpoRecurso);
		$recurso->Recomendado = $request->Recomendado;
		$recurso->IdUsuario = $request->IdUsuario;
		$recurso->IdTipoRecurso = $request->tiporecurso["IdTipoRecurso"];
		$recurso->Activo = $request->Activo;
        $recurso->Oculto = $request->Oculto;                
         //Guardamos el cambio en nuestro modelo
         if ($recurso->save()) {
             return response()->json(array( $request->idRecurso.'success' => true, 'last_insert_id' => $recurso->IdRecurso), 200);			
         } else {
             return response()->json(array('ERROR' => false, 'last_insert_id' => 0), 500);	
         }
          
    }
    


    /**
     * Display the specified resource.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show(Recurso $recurso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurso $recurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurso $recurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
   
    public function destroy(Request $request)
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

        try {                                     
        $now = new \DateTime();                    
        DB::table('recursos')
        ->where('idRecurso', $request->IdRecurso)
        ->update(['FechaBaja' => $now->format('Y-m-d H:i:s')]);

        return response()->json(array( 'success' => true, 'update_id' => $request->IdRecurso), 200);	
        }
        catch (Exception $e ) {            
            return response()->json([
                'success' => false,              
                'message' => 'Error ale eliminar'.$e               
            ], 422);
        }            
    }
}
