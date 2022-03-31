<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
	protected $table 		= 'pacientes'	;
    protected $guarded = ['id'];

    public function muestras(){
        return $this->hasMany(Muestras::class,'id','paciente_id' );
    }
	
}