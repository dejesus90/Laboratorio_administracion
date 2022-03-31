<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
	protected $table 		= 'paises'	;

	public function estados(){
        return $this->hasMany('App\Models\estados' , 'id_pais' )->orderBy('id');
    }
}