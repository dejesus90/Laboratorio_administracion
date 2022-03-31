<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratoriosrechazados extends Model
{
	protected  $table 		= 'laboratorios_rechazado'	;
    // protected $fillable = ['nombre','pais_id','estado_id'];
    protected  $guarded = ['id'];
    
}