<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    //Indicar cual es la tabla de la base de datos que estará representando
    protected $table = 'modelos';

    // Indicar que valores se pueden escribir
    protected $fillable = [
        'marca', 'modelo'
    ];

    //Relaciones One To Many - De uno a muchos
    public function aeronaves(){
        return $this->hasMany('App\Aeronave');
    }

}
