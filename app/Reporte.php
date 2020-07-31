<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    //Indicar cual es la tabla de la base de datos que estará representando
    protected $table = 'reportes';

    // Indicar que valores se pueden escribir
    protected $fillable = [
        'orden_id', 'servicio_id', 'estado', 'imagen'
    ];

    //Relaciones de Many To One - De muchos a uno
    public function orden(){
        return $this->belongsTo('App\Orden', 'orden_id');
    }

    public function servicio(){
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }
}
