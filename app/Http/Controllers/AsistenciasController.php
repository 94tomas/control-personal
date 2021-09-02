<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use \Carbon\Carbon;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Asistencia::orderBy('created_at', 'DESC')
            // ->get();
            ->paginate(10);

        // dd($lista);
        foreach ($lista as $item) {
            // formato de fecha
            $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
            $fecha = Carbon::parse(date($item->fecha));
            $mes = $meses[($fecha->format('n')) - 1];
            $item->fecha = $fecha->format('d') .'-'. $mes .'-'. $fecha->format('Y');
            // end formato fecha

            // Hora de entrada
            $hrEntrada = $item->empleado->horario->hora_inicio;
            $hrSalida = $item->empleado->horario->hora_fin;
            // dd($item->hora);
            // end Hora de entrada
        }

        return view('asistencias.index')->with([
            'lista' => $lista
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
