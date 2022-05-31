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
    /**
     * reporte
     */
    public function reportNomina()
    {
        $lista = Empleado::orderBy('created_at', 'DESC')
            ->with('cargo')
            ->get();
    
        $pdf = \PDF::loadView('nomina-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('nomina.pdf');
        
        // return view('nomina-pdf', [
        //     'lista' => $lista
        // ]);
    }
}
