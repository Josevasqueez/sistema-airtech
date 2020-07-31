<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aeronave extends Model
{
    //Indicar cual es la tabla de la base de datos que estará representando
    protected $table = 'aeronaves';

    // Indicar que valores se pueden escribir
    protected $fillable = [
        'siglas', 'seriales', 'estado', 'imagen', 'id_users', 'id_modelos'
    ];
    //Relaciones One To Many - De uno a muchos
    public function ordenes(){
        return $this->hasMany('App\Orden');
    }

    //Relaciones de Many To One - De muchos a uno
    public function usuario(){
        return $this->belongsTo('App\User', 'id_users');
    }

    public function modelo(){
        return $this->belongsTo('App\Modelo', 'id_modelos');
    }
}
