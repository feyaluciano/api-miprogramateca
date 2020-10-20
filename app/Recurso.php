<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\TipoRecurso;
class Recurso extends Model
{
    protected $table='recursos';

    protected $primaryKey='IdRecurso';

    //public  $timestamps = true;
	//protected $TipoRecurso='ttttttttttt';
	 
protected  $fillable =[
    'IdRecurso',
    	'Titulo',
    	'TituloUrl',		
		'CuerpoRecurso',		
        'Recomendado',
        'IdTipoRecurso',
        'Activo',
        'FechaCreacion',
        'FechaBaja',
        'created_at',
    ];

    protected $guarded =[

    ];
	
	
	// Relación
	
  public function tiporecurso() {
       return $this->hasOne(TipoRecurso::class,'IdTipoRecurso','IdTipoRecurso');// Le indicamos que se va relacionar con el atributo, como no uso el atributo llamado id, 
       //nombro yo a las claves
       
    }

	public function Usuario() {
        return $this->hasOne('programateca\Usuario', 'IdUsuario'); // Le indicamos que se va relacionar con el atributo 
    }
	
    

}
