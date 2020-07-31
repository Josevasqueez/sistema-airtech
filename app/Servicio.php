<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{   
    //Indicar cual es la tabla de la base de datos que estará representando
    protected $table = 'servicios';

    // Indicar que valores se pueden escribir
    protected $fillable = [
        'tipo', 'nombre', 'descripcion'
    ];

    //Relaciones One To Many - De uno a muchos
    public function reportes(){
        return $this->hasMany('App\Reporte');
    }
}
