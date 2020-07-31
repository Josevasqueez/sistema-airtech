<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    //Indicar cual es la tabla de la base de datos que estará representando
    protected $table = 'ordenes';

    // Indicar que valores se pueden escribir
    protected $fillable = [
        'observaciones', 'aeronave_id'
    ];

    //Relaciones One To Many - De uno a muchos
    public function reportes(){
        return $this->hasMany('App\Reporte');
    }

    //Relaciones de Many To One - De muchos a uno
    public function aeronave(){
        return $this->belongsTo('App\Aeronave', 'aeronave_id');
    }
}
