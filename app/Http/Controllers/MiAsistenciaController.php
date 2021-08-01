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

        $emp = Empleado::select('id', 'cod_empleado', 'horario_id')
            ->where('cod_empleado', $request->cod_empleado)
            ->with('horario')
            ->first();

        // $nuevo = new Asistencia;
        $tmpHora = Carbon::create($request->hora);
        $tmpHoraEntrada = Carbon::create($emp->horario->hora_inicio);
        $tmpHoraSalida = Carbon::create($emp->horario->hora_fin);
        // $initDate = Carbon::now()->firstOfMonth()->format('Y-m-d H:i:s');
        $difEntrada = $tmpHoraEntrada->DiffInMinutes($tmpHora);
        $difSalida = $tmpHoraSalida->DiffInMinutes($tmpHora);

        // $init = $diferencia;
        // $day = floor($init / 86400);
        // $hours = floor(($init -($day*86400)) / 3600);
        // $minutes = floor(($init / 60) % 60);
        // $seconds = $init % 60;

        // echo "$day:$hours:$minutes:$seconds";

        dd([
            'ingreso' => $tmpHora,
            'Entrada' => $tmpHoraEntrada,
            'dif_entrada' => $difEntrada,
            'dif_salida' => $difSalida,
        ]);
    }
}
