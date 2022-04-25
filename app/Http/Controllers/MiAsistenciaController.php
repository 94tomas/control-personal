<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Empleado;
use App\Models\Asistencia;

class MiAsistenciaController extends Controller
{
    public function index()
    {
        return view('marcar-asistencia');
    }
    public function mainMarcar(Request $request)
    {
        $request->validate([
            'cod_empleado' => 'required'
        ]);

        if (!Empleado::where('cod_empleado', $request->cod_empleado)->exists()) {
            return back();
        }

        $emp = Empleado::select('id', 'cod_empleado', 'horario_id')
            ->with('horario')
            ->where('cod_empleado', $request->cod_empleado)
            ->first();
        
        // cantidad ya marcadas
        $now = Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $cantAssis = Asistencia::where('empleado_id', $emp->id)
            ->where(function($x) use($now) {
                $x->where('fecha', '>=', $now);
                $x->where('fecha', '<=', $now);
            })->count();

        // cantidad que debe marcar
        $cantMark = 0;
        $cantMark += ($emp->horario->hora_inicio)?1:0;
        $cantMark += ($emp->horario->hora_fin)?1:0;
        $cantMark += ($emp->horario->hora_descanso)?1:0;
        $cantMark += ($emp->horario->hora_fin_descanso)?1:0;

        // verificar horario actual y tipo
        $tmpHorario = null;
        $tipoHorario = null;
        if ($cantMark == 2) {
            switch ($cantAssis) {
                case 1:
                    $tmpHorario = $emp->horario->hora_fin;
                    $tipoHorario = 'Salida 1';
                    break;
                default:
                    $tmpHorario = $emp->horario->hora_inicio;
                    $tipoHorario = 'Entrada 1';
                    break;
            }
        }
        if ($cantMark == 4) {
            switch ($cantAssis) {
                case 1:
                    $tmpHorario = $emp->horario->hora_descanso;
                    $tipoHorario = 'Salida 1';
                    break;
                case 2:
                    $tmpHorario = $emp->horario->hora_fin_descanso;
                    $tipoHorario = 'Entrada 2';
                    break;
                case 3:
                    $tmpHorario = $emp->horario->hora_fin;
                    $tipoHorario = 'Salida 2';
                    break;
                default:
                    $tmpHorario = $emp->horario->hora_inicio;
                    $tipoHorario = 'Entrada 1';
                    break;
            }
        }

        // marcar
        $fechaHoy = (date('Y-m-d'))?Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s'):'';
        $tipo = '';
        if ($cantAssis < $cantMark) {
            $mark = new Asistencia;
            $mark->empleado_id = $emp->id;
            $mark->fecha = $fechaHoy;
            $mark->hora = Carbon::create($request->hora);
            $mark->horario = $tmpHorario;
            $mark->tipo = $tipoHorario;
            $mark->save();
        } else {
            return back()->with('error', 'Usted ya registro todos los horarios que le corresponde.');
        }

        if ($cantAssis%2 == 0) {
            $tipo = 'entrada';
        }
        if ($cantAssis%2 != 0) {
            $tipo = 'salida';
        }

        return back()->with('ok', 'Registro con éxito.');
    }
    /**
     * 
     * Diferencia en minutos
     * 
     */
    public function diffTiempos($tmpTime, $currentTime)
    {   
        $tmpTime = Carbon::create($tmpTime);
        $currentTime = Carbon::create($currentTime);
        // $signo = ($currentTime >= $tmpTime)?-1:1;
        return $currentTime->DiffInMinutes($tmpTime);
    }
}
