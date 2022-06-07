<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Empleado;
use App\Models\Horario;
use App\Models\Cargo;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'users' => User::count(),
            'employee' => Empleado::count(),
            'hours' => Horario::count(),
            'charges' => Cargo::count(),
        ];
        return view('dashboard', ['data'=>$data]);
    }
}
