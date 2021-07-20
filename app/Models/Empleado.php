<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    // cargo
    public function cargo()
    {
        return $this->belongsTo('App\Models\Cargo');
    }
    // horario
    public function horario()
    {
        return $this->belongsTo('App\Models\Horario');
    }
}
