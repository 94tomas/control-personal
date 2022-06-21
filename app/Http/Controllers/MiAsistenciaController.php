<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Empleado;
use App\Models\Asistencia;
use App\Models\Horario;

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
        
        $emp = Empleado::select('id', 'cod_empleado')
            ->where('cod_empleado', $request->cod_empleado)
            ->first();
        
        $listaHorarios = Horario::where('empleado_id', $emp->id)
            ->where('dia', date('D'))
            ->get();

        if (count($listaHorarios) <= 0) {
            return back()->with('error', 'No cuenta con ningún horario para registrar en este día.');
        }
        
        // cantidad ya marcadas
        $now = Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $cantAssis = Asistencia::where('empleado_id', $emp->id)
            ->where(function($x) use($now) {
                $x->where('fecha', '>=', $now);
                $x->where('fecha', '<=', $now);
            })->count();

        // cantidad que debe marcar
        $cantMark = 0;
        $arrayHrs = array(); 
        foreach ($listaHorarios as $itemHr) {
            $cantMark += ($itemHr->hora_inicio)?1:0;
            $cantMark += ($itemHr->hora_fin)?1:0;

            array_push($arrayHrs, ['inicio' => $itemHr->hora_inicio, 'fin' => $itemHr->hora_fin]);
        }

        $nowTime = Carbon::parse(date('H:i:s'))->format('H:i:s');
        $timestamp = strtotime($nowTime);
        $diff = null;
        $i = null;
        $j = null;

        foreach ($arrayHrs as $a => $row) {
            foreach ($row as $b => $time) {
                $currDiff = abs($timestamp - strtotime($time));
                if (is_null($diff) || $currDiff < $diff) {
                    $i = $a;
                    $j = $b;
                    $diff = $currDiff;
                }
            }
        }

        $minutes = ($diff / 60);
        if ($minutes >= 20) {
            return back()->with('error', 'Registro fuera de hora.');
        }

        // verificar horario actual y tipo
        $tmpHorario = null;
        $tipoHorario = null;

        $tmpHorario = $arrayHrs[$i][$j];
        $tipoHorario = $j;

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
