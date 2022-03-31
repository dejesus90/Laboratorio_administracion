<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
	protected  $table 		= 'laboratorio'	;
    // protected $fillable = ['nombre','pais_id','estado_id'];
    protected  $guarded = ['id'];

    public function paisLab(){
        return $this->hasOne(Paises::class , 'id' , 'pais_id');
    }
    public function infousuario()
    {
        return $this->hasOne(Usuarioinfo::class , 'laboratorio__id');
    }
    public function rechazados()
    {
        return $this->hasMany(Laboratoriosrechazados::class , 'id_laboratorio');
    }
}