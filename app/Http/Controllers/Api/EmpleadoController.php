<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Horario;
use App\Models\Empleado;
use App\Models\Asistencia;
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
        $tmpDate = explode('/', strval($request->fecha_nacimiento));
        $tmpDate2 = $tmpDate[0].'/'.$tmpDate[1].'/'.$tmpDate[2];
        $time = strtotime($tmpDate2);
        $newformat = date('Y-m-d',$time);

        $empleado = new Empleado;
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->direccion = $request->direccion;
        $empleado->tel_cel = $request->tel_cel;
        $empleado->fecha_nacimiento = $newformat;
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
            'cod_empleado' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        if (!Empleado::where('cod_empleado', $request->cod_empleado)->exists()) {
            return back();
        }

        $emp = Empleado::select('id', 'cod_empleado', 'horario_id')
            ->with('horario')
            ->where('cod_empleado', $request->cod_empleado)
            ->first();

        // Hora del usuario
        $tmpHora = Carbon::create($request->hora);
        $fechaHoy = (date('Y-m-d'))?Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s'):'';
        $ultimoReg = Asistencia::select('id', 'hora')
            ->where('empleado_id', $emp->id)
            ->where(function($x) use($fechaHoy) {
                if ($fechaHoy!=='') {
                    $x->where('fecha', '>=', $fechaHoy);
                    $x->where('fecha', '<=', $fechaHoy);
                }
            })
            ->orderBy('created_at', 'DESC')
            ->first();

        $horaReg = ($ultimoReg) ? Carbon::create($ultimoReg->hora) : '';
        $diferencia = ($horaReg!='') ? $horaReg->DiffInMinutes($tmpHora) : 100;
        if ($diferencia > 10) {
            $nuevo = new Asistencia;
            $nuevo->hora = $request->hora;
            $nuevo->fecha = $fechaHoy;
            $nuevo->empleado_id = $emp->id;
            $nuevo->save();
            return response()->json('ok', 200);
        } else {
            return response()->json('info', 422);
        }
    }
}
