<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/algo', function () {
    
    return "algooo";
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware'=>['ControlAccesoPorToken']],function(){ //ACA SE PUEDEN AGREGAR CON , (COMA VARIOS MIDELWARE, EL SIGUIENTE PODRIA SER VER EL PERFIL)
//Route::group(['middleware'=>['ParaCors','ControlAccesoPorToken']],function(){ //ACA SE PUEDEN AGREGAR CON , (COMA VARIOS MIDELWARE, EL SIGUIENTE PODRIA SER VER EL PERFIL)
    Route::post('Recurso/recursos', 'RecursoController@Index');
    // Route::post('Recurso/store', 'RecursoController@store');
    //Route::post('TipoRecurso/tiposrecursos', 'TipoRecursoController@Index');
   // Route::post('Recurso/store', 'RecursoController@store');
});
//Route::resource('store', 'RecursoController');


///Route::post('Usuario/loginXXX', 'UsuarioController@login');


//Auth::all(); NO SE SI FUNCINA ESTO, PROBAR, PARA NO USAR TOKENS NI NADA

//CON LAS SIGUIENTES RUTAS CREO EL TOKEN, NO VA BAJO MIDELWARE YA QUE SI O SI SE PUEDEN EJECUTAR 
//Route::group([['middleware'=>['ParaCors','ControlAccesoPorToken'],    'prefix'=>'v1'],function(){
Route::group(['prefix'=>'v1'],function(){
    Route::get('TipoRecurso/tiposrecursos', 'TipoRecursoController@Index');
    Route::get('/Recurso/{IdTipoRecurso}', 'RecursoController@getPorId');
    Route::get('/UnRecurso/{IdRecurso}', 'RecursoController@getRecursoPorId');
    
    Route::get('/UnTipoRecurso/{IdTipoRecurso}', 'TipoRecursoController@getTipoRecursoPorId');


    Route::post('/auth/login','TokensController@login');

    Route::post('/auth/loginadmin','TokensController@loginadmin');

    Route::post('/auth/chequearemail','UsuarioController@chequearEmail');
    Route::get('/auth/validaremail/{codigoValidacion}','UsuarioController@validarEmail');
    Route::post('/auth/registro','UsuarioController@registro');
    Route::post('/auth/refresh','TokensController@refreshToken');
    Route::post('/auth/expire','TokensController@expireToken');
     Route::post('Recurso/store', 'RecursoController@store');



     Route::post('Recurso/buscar', 'RecursoController@buscar');

     Route::post('TipoRecurso/buscar', 'TipoRecursoController@buscar');

     Route::post('Archivo/subirImagen', 'ArchivoController@subirImagen');


     //Route::post('Recurso/delete', 'RecursoController@destroy');

     Route::get('/Recurso/delete/{IdRecurso}', 'RecursoController@destroy');

     Route::get('/TipoRecurso/cambiardeestado/{IdTipoRecurso}', 'TipoRecursoController@cambiarDeEstado');


     Route::post('Recurso/storeObjetoCompleto', 'RecursoController@storeObjetoCompleto');


     Route::post('TipoRecurso/storeObjetoCompleto', 'TipoRecursoController@storeObjetoCompleto');

     Route::get('/Recursos/ultimosrecursos', 'RecursoController@getUltimosRecursos');

     Route::get('/Recursos', 'RecursoController@getRecursos');

     Route::get('/TotalesPanel', 'RecursoController@totalesPanel');
     
     Route::get('/RecursosPaginado/{page}', 'RecursoController@getRecursosPaginado');

});



