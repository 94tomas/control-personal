<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;

class CargosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista = Cargo::orderBy('created_at', 'DESC')
            ->paginate(10);
        // dd($lista);
        return view('cargos.index')->with('lista', $lista);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargos.create');
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
            'nombre_cargo' => 'required',
            'descripcion' => 'required',
            // 'tipo' => 'required',
            // 'tarifa' => 'required'
        ]);

        $cargo = new Cargo;
        $cargo->nombre_cargo = $request->nombre_cargo;
        $cargo->descripcion = $request->descripcion;
        // $cargo->tipo = $request->tipo;
        // $cargo->tarifa = $request->tarifa;
        $cargo->save();

        return redirect('/cargos/lista')->with('ok', 'Registro éxitoso.');
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
        $dCargo = Cargo::find($id);
        return view('cargos.edit')->with('cargo', $dCargo);
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
            'nombre_cargo' => 'required',
            'descripcion' => 'required',
            // 'tipo' => 'required',
            // 'tarifa' => 'required'
        ]);

        $cargo = Cargo::find($id);
        $cargo->nombre_cargo = $request->nombre_cargo;
        $cargo->descripcion = $request->descripcion;
        // $cargo->tipo = $request->tipo;
        // $cargo->tarifa = $request->tarifa;
        $cargo->estado = ($request->estado)?1:0;
        $cargo->save();

        return redirect('/cargos/lista')->with('ok', 'Actualización exitosa.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Cargo::find($id);
        $del->delete();
        return back()->with('ok', 'Se eliminó el cargo correctamente.');
    }

    /**
     * report
     */
    public function reportCargos()
    {
        $lista = Cargo::orderBy('created_at', 'DESC')
            ->get();

        $pdf = \PDF::loadView('cargos.cargos-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('cargos.pdf');
        
        // return view('cargos.cargos-pdf', [
        //     'lista' => $lista
        // ]);
    }
}
