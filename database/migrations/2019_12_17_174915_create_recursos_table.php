<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->bigIncrements('idRecurso');
            $table->engine = 'InnoDB';       
			$table->collation = 'utf8mb4_general_ci';                            
            $table->string('Titulo');
            $table->string('TituloUrl'); 
			$table->string('CuerpoRecurso');  
			$table->boolean('Recomendado'); 			
			$table->boolean('Activo');
			$table->timestamps();
			
			$table->integer('IdUsuario')->unsigned();    
			$table->foreign('IdUsuario')->references('idUsuario')->on('usuarios'); 
			$table->integer('IdTipoRecurso')->unsigned();   
			$table->foreign('IdTipoRecurso')->references('IdTipoRecurso')->on('tiposrecursos'); 
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recursos');
    }
}
