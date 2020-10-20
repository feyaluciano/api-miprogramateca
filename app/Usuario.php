<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Usuario  extends Authenticatable 
{
     protected $table='usuarios';

    protected $primaryKey='IdUsuario';
	 
protected  $fillable =[
    	'Nombre',
		'Apellido',
    	'Email',
        'Password',	
        'codigo_confirmacion',	
        'confirmado',				
    	'Activo',
    ];

    protected $guarded =[

    ];
    protected $hidden = [
        'Password', 'remember_token',
    ];
	
	public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
	
}
