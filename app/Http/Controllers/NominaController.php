<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class NominaController extends Controller
{
    public function index()
    {
        $lista = Empleado::orderBy('created_at', 'DESC')
            ->with('cargo')
            ->paginate(10);

        return view('nomina')->with('lista', $lista);
    }
}
