<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarCamposAUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table ('Usuarios',function(Blueprint $table) {
            $table->string('idUsuarioFacebook');
            $table->string('UrlImagen');
            $table->string('Nick');
            $table->string('CodigoRecordar');
            $table->dateTime('UltimoAcceso');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
