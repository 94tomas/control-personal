<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

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
        return view('horarios.create');
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
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $nuevo = new Horario;
        $nuevo->hora_inicio = $request->hora_inicio;
        $nuevo->hora_descanso = $request->hora_descanso;
        $nuevo->hora_fin = $request->hora_fin;
        $nuevo->hora_fin_descanso = $request->hora_fin_descanso;
        $nuevo->save();

        return redirect('/horarios/lista');
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
        return view('horarios.edit')->with('horario', $hor);
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
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $editar = Horario::find($id);
        $editar->hora_inicio = $request->hora_inicio;
        $editar->hora_descanso = $request->hora_descanso;
        $editar->hora_fin = $request->hora_fin;
        $editar->hora_fin_descanso = $request->hora_fin_descanso;
        $editar->estado = ($request->estado)?1:0;
        $editar->save();

        return redirect('/horarios/lista');
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
        return back();
    }
}
