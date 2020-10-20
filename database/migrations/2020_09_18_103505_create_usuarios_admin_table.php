<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('usuariosadmin', function (Blueprint $table) {
            $table->engine = 'InnoDB';       
			$table->collation = 'utf8mb4_general_ci';                 
            $table->increments('IdUsuarioAdmin');
            $table->string('Email');
            $table->string('Password'); 
			$table->string('Nombre');  
			$table->string('Apellido'); 			
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
        Schema::dropIfExists('usuariosadmin');
    }
}
