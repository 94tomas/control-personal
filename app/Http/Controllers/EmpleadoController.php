<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Horario;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = ($request->search)??'';

        $lista = Empleado::orderBy('created_at', 'DESC')
            ->where(function($x) use($search) {
                if ($search != '') {
                    $x->where('cod_empleado', 'like', '%'.$search.'%');
                    $x->orWhere('nombres', 'like', '%'.$search.'%');
                    $x->orWhere('apellidos', 'like', '%'.$search.'%');
                }
            })
            ->with('cargo')
            ->paginate(10);

        return view('personal.index')->with('lista', $lista);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $horarios = Horario::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();
        $cargos = Cargo::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();
        return view('personal.create')->with(['horarios' => $horarios, 'cargos' => $cargos]);
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'tel_cel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'cargo_id' => 'required'
        ]);

        // dd($request);
        // dd($request->horarios);

        $empleado = new Empleado;
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->direccion = $request->direccion;
        $empleado->tel_cel = $request->tel_cel;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;
        $empleado->genero = $request->genero;
        $empleado->cargo_id = $request->cargo_id;
        // $empleado->horario_id = $request->horario_id;
        $empleado->save();

        foreach ($request->horarios as $day => $itemHr) {
            foreach ($itemHr as $val) {
                $newHr = new Horario;
                $newHr->dia = $day;
                $newHr->titulo = $val['titulo'];
                $newHr->hora_inicio = $val['hora_inicio'];
                $newHr->hora_fin = $val['hora_fin'];
                $newHr->empleado_id = $empleado->id;
                $newHr->save();
            }
        }

        $strCode = '';
        for ($i=0; $i < (3-strlen(strval($empleado->id))); $i++) {
            $strCode = $strCode.'0';
        }
        $empleado->cod_empleado = 'PE' . $strCode . $empleado->id;
        $empleado->save();

        return redirect('/personal/lista')->with('ok', 'Registro éxitoso.');
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
        $dEmpleado = Empleado::where('id', $id)
            ->with('horarios')->first();
        $horarios = Horario::select('id', 'dia', 'titulo', 'hora_inicio', 'hora_fin')
            ->orderBy('created_at', 'DESC')
            ->where('estado', 1)
            ->where('empleado_id', $dEmpleado->id)->get();
        $cargos = Cargo::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();
            
        return view('personal.edit')->with([
            'empleado' => $dEmpleado,
            'horarios' => $horarios,
            'cargos' => $cargos
        ]);
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'tel_cel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'cargo_id' => 'required'
        ]);

        // dd($request);
        $empleado = Empleado::find($id);
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->direccion = $request->direccion;
        $empleado->tel_cel = $request->tel_cel;
        $empleado->fecha_nacimiento = $request->fecha_nacimiento;
        $empleado->genero = $request->genero;
        $empleado->cargo_id = $request->cargo_id;
        // $empleado->horario_id = $request->horario_id;
        $empleado->estado = ($request->estado)?1:0;
        $empleado->save();

        Horario::where('empleado_id', $empleado->id)->delete();
        foreach ($request->horarios as $day => $itemHr) {
            foreach ($itemHr as $val) {
                $newHr = new Horario;
                $newHr->dia = $day;
                $newHr->titulo = $val['titulo'];
                $newHr->hora_inicio = $val['hora_inicio'];
                $newHr->hora_fin = $val['hora_fin'];
                $newHr->empleado_id = $empleado->id;
                $newHr->save();
            }
        }

        return redirect('/personal/lista')->with('ok', 'Actualización exitosa.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = Empleado::find($id);
        $del->delete();
        return back()->with('ok', 'Se eliminó al usuario correctamente.');
    }

    /**
     * report
     */
    public function reportPersonal(Request $request)
    {
        $search = ($request->search)??'';

        $lista = Empleado::orderBy('created_at', 'DESC')
            ->where(function($x) use($search) {
                if ($search != '') {
                    $x->where('cod_empleado', 'like', '%'.$search.'%');
                    $x->orWhere('nombres', 'like', '%'.$search.'%');
                    $x->orWhere('apellidos', 'like', '%'.$search.'%');
                }
            })
            ->with('cargo')
            ->get();

        $pdf = \PDF::loadView('personal.personal-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('empleados.pdf');
        
        // return view('personal.personal-pdf', [
        //     'lista' => $lista
        // ]);
    }

    /**
     * horarios
     */
    public function horariosPorCargo(Request $request)
    {
        $cargo = $request->cargo;
        $data = Horario::where('cargo_id', $cargo)
            ->orderBy('created_at', 'DESC')
            ->get();

        $content = '';
        foreach ($data as $item) {
            $content .= '<option value="'.$item->id.'">';
            $content .= $item->titulo.': ' .$item->hora_inicio. ' - ' .$item->hora_fin;
            $content .= '</option>';
        }

        return response()->json($content, 200);
    }
}
