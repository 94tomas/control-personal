<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Horario;
use App\Models\Empleado;
use Carbon\Carbon;
use Validator;

class EmpleadoController extends Controller
{
    public function showData()
    {
        $horarios = Horario::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();
        $cargos = Cargo::orderBy('created_at', 'DESC')
            ->where('estado', 1)->get();

        $data = [
            'horarios' => $horarios,
            'cargos' => $cargos
        ];
        return response()->json($data, 200);
    }
    public function registerEmpl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'tel_cel' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6',
            'fecha_nacimiento' => 'required',
            'genero' => 'required',
            'cargo_id' => 'required',
            'horario_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }
        
        $empleado = new Empleado;
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->direccion = $request->direccion;
        $empleado->tel_cel = $request->tel_cel;
        $empleado->fecha_nacimiento = Carbon::create($request->fecha_nacimiento)->format('Y-m-d');
        $empleado->genero = $request->genero;
        $empleado->cargo_id = $request->cargo_id;
        $empleado->horario_id = $request->horario_id;
        $empleado->save();

        $strCode = '';
        for ($i=0; $i < (3-strlen(strval($empleado->id))); $i++) {
            $strCode = $strCode.'0';
        }
        $empleado->cod_empleado = 'PE' . $strCode . $empleado->id;
        $empleado->save();

        return response()->json('ok', 200);
    }
    public function listEmpleados()
    {
        $lista = Empleado::orderBy('created_at', 'DESC')
            ->with('cargo')
            ->get();

        return response()->json($lista, 200);
    }
    /**
     * Marcar asistencia
     */
    public function Asistencia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        return response()->json('listo', 200);
    }
}
