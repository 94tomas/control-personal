<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Cargo;
use DateTime;

class HorariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Horario::orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('horarios.index')->with('lista', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cargos = Cargo::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();

        return view('horarios.create')->with(['cargos' => $cargos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tolerancia' => 'required',
            'cargo_id' => 'required'
        ]);

        $hrInicio = date('Y-m-d H:i:s', strtotime($request->hora_inicio));
        $hrFin = date('Y-m-d H:i:s', strtotime($request->hora_fin));

        if ($hrInicio >= $hrFin) {
            return back()->with('error', 'Error en rango de horarios.')->withInput();
        }

        $nuevo = new Horario;
        $nuevo->hora_inicio = $request->hora_inicio;
        // $nuevo->hora_descanso = $request->hora_descanso;
        $nuevo->hora_fin = $request->hora_fin;
        // $nuevo->hora_fin_descanso = $request->hora_fin_descanso;
        $nuevo->titulo = $request->titulo;
        $nuevo->tolerancia = $request->tolerancia;
        $nuevo->cargo_id = $request->cargo_id;
        $nuevo->save();

        return redirect('/horarios/lista')->with('ok', 'Registro éxitoso.');
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
        $hor = Horario::find($id);
        
        $cargos = Cargo::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();
        
        return view('horarios.edit')->with(['cargos' => $cargos, 'horario' => $hor]);
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
        $request->validate([
            'titulo' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'tolerancia' => 'required',
            'cargo_id' => 'required'
        ]);

        $editar = Horario::find($id);
        $editar->hora_inicio = $request->hora_inicio;
        // $editar->hora_descanso = $request->hora_descanso;
        $editar->hora_fin = $request->hora_fin;
        // $editar->hora_fin_descanso = $request->hora_fin_descanso;
        $editar->estado = ($request->estado)?1:0;
        $editar->tolerancia = $request->tolerancia;
        $editar->titulo = $request->titulo;
        $editar->cargo_id = $request->cargo_id;
        $editar->save();

        return redirect('/horarios/lista')->with('ok', 'Actualización exitosa.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Horario::find($id);
        $del->delete();
        return back()->with('Se eliminó rl horario correctamente.');
    }

    /***
     * report
     */
    public function reportHorarios()
    {
        $lista = Horario::orderBy('created_at', 'DESC')
            ->get();

        $pdf = \PDF::loadView('horarios.horarios-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('horarios.pdf');
        
        // return view('horarios.horarios-pdf', [
        //     'lista' => $lista
        // ]);
    }
}
