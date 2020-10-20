<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiposrecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('tiposrecursos', function (Blueprint $table) {
            $table->engine = 'InnoDB';       
			$table->collation = 'utf8mb4_general_ci';                 
            $table->increments('IdTipoRecurso');
            $table->string('NombreTipoRecurso');
            $table->string('Descripcion'); 
			$table->string('Imagen');  
			$table->string('Color'); 
			$table->integer('Cantidad'); 
			$table->boolean('Activo');
			$table->timestamps();			            
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiposrecursos');
    }
}
