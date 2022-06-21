<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    // empleado
    public function empleado()
    {
        return $this->hasMany('App\Models\Empleado');
    }
}
