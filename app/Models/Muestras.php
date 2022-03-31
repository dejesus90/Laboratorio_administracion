<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muestras extends Model
{
	protected  $table 		= 'muestras'	;
    // protected $fillable = ['nombre','pais_id','estado_id'];
    protected  $guarded = ['id'];

    public function estadomuestra(){
        return $this->hasOne(Estadomuestras::class,'id','estado_id' );
    }
    public function paciente(){
        return $this->hasOne(Pacientes::class,'id','paciente_id' );
    }
    public function examen(){
        return $this->hasOne(Examenes::class,'id','examen_id' );
    }

}