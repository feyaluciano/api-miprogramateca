<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoRecurso extends Model
{
   protected $table='tiposrecursos';

    protected $primaryKey='IdTipoRecurso';
	 
protected  $fillable =[
    	'NombreTipoRecurso',
    	'Descripcion',
        'Imagen',
        'ImagenBase64',
		'Color',
		'Cantidad',
    	'Activo',
    ];

public function recurso() {
        return $this->hasOne('programateca\Recurso', 'IdRecurso'); 
    }

    protected $guarded =[

    ];
	
	public function TipoRecurso()
    {     
	 return $this->belongsTo(Recurso::class, 'IdRecurso', 'IdRecurso');
        //return $this->belongsTo('programateca\Recurso', 'IdRecurso', 'IdRecurso');
    }
} 


