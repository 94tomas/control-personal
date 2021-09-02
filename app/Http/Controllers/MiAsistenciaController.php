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

        $emp = Empleado::select('id', 'cod_empleado')
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
            return back()->with('ok', 'Registro con éxito.');
        } else {
            return back()->with('info', 'Ya realizo un registro en los ultimos 10 minutos.');
        }
    }

    /**
     * 
     **********************/
    // // Hora del usuario
    // $tmpHora = Carbon::create($request->hora);
    // // cantidad que un empleado debe marcar en un dia
    // $cantRegRequeridos = $this->cantRegistrosRequeridos($emp);
        
    // // Obteniendo la cantidad de veces que registro el empleado hoy dia
    // $cantRegActual = $this->cantRegistrosEnElDia($emp);
    
    // // 
    // if ($cantRegRequeridos == 4) {
    //     switch ($cantRegActual) {
    //         case 1:
    //             break;
    //         case 2:
    //             break;
    //         case 3:
    //             break;
    //         default:
    //             // Verificamos si aun puede registrar su entrada
    //             $ifEntrada = $this->verificarHora($emp, 'entrada', 15, $tmpHora);
    //             dd($ifEntrada);
    //             break;
    //     }
    // } elseif ($cantRegRequeridos == 2) {
    //     dd('2 horas');
    // }
    // dd($cantRegActual);
    // // $nuevo = new Asistencia;
    // // inicio y fin del dia
    // $tmpHoraEntrada = Carbon::create($emp->horario->hora_inicio);
    // $tmpHoraSalida = Carbon::create($emp->horario->hora_fin);
    // // descanso
    // $tmpHoraDescanso = ($emp->horario->hora_descanso)?Carbon::create($emp->horario->hora_descanso):'vacio';
    // $tmpHoraFinDescanso = ($emp->horario->hora_fin_descanso)?Carbon::create($emp->horario->hora_fin_descanso):'vacio';
    // // $initDate = Carbon::now()->firstOfMonth()->format('Y-m-d H:i:s');
    // $difEntrada = $tmpHoraEntrada->DiffInMinutes($tmpHora);
    // $difSalida = $tmpHoraSalida->DiffInMinutes($tmpHora);

    // dd([
    //     'ingreso' => $tmpHora,
    //     'Entrada' => $tmpHoraEntrada,
    //     'dif_entrada' => $difEntrada,
    //     'dif_salida' => $difSalida,
    // ]);
    /************
     * 
     * 
     */
    // funciones extras
    // public function cantRegistrosRequeridos($emp)
    // {
    //     $con = 0;
    //     if ($emp->horario->hora_inicio) $con+=1;
    //     if ($emp->horario->hora_fin) $con+=1;
    //     if ($emp->horario->hora_descanso) $con+=1;
    //     if ($emp->horario->hora_fin_descanso) $con+=1;
    //     return $con;
    // }
    // public function cantRegistrosEnElDia($emp)
    // {
    //     $fechaHoy = (date('Y-m-d'))?Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s'):'';
    //     $cant = Asistencia::select()
    //         ->where('empleado_id', $emp->id)
    //         ->where(function($x) use($fechaHoy) {
    //             if ($fechaHoy!=='') {
    //                 $x->where('fecha', '>=', $fechaHoy);
    //                 $x->where('fecha', '<=', $fechaHoy);
    //             }
    //         })
    //         ->count();
    //     return $cant;
    // }
    // public function verificarHora($emp, $tipo, $tolerancia, $tmpHora)
    // {
    //     $tmpHoraEntrada = Carbon::create($emp->horario->hora_inicio);
    //     switch ($tipo) {
    //         case 'entrada':
    //             $difEntrada = $tmpHoraEntrada->DiffInMinutes($tmpHora);
    //             if ($difEntrada > $tolerancia) {
    //                 // return 'tarde';
    //             }
    //             break;
    //         default:
    //             break;
    //     }
    //     return $difEntrada;
    // }
}
