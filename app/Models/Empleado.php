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
    // asistencia
    public function asistencia()
    {
        return $this->hasMany('App\Models\Asistencia');
    }
    // justificacion
    public function justificacion()
    {
        return $this->hasMany('App\Models\Justificacion');
    }
    // permiso
    public function permiso()
    {
        return $this->hasMany('App\Models\Permiso');
    }
    // sancion
    public function sancion()
    {
        return $this->hasMany('App\Models\Sancion');
    }
    // vacacion
    public function vacacion()
    {
        return $this->hasMany('App\Models\Vacacion');
    }
}
