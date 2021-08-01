<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    // empleado
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado');
    }
}
