<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    // // empleado
    // public function empleado()
    // {
    //     return $this->hasMany('App\Models\Empleado');
    // }

    /**
     * The empleados that belong to the Horario
     *
     */
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'horario_empleado');
    }

    // cargo
    public function cargo()
    {
        return $this->belongsTo('App\Models\Cargo');
    }
}
