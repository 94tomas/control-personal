<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use \Carbon\Carbon;

class AsistenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $personal = ($request->personal)??'';
        $fecha_init = ($request->fecha_init)?Carbon::parse($request->fecha_init)->format('Y-m-d H:i:s'):'';
        $fecha_end = ($request->fecha_end)?Carbon::parse($request->fecha_end)->format('Y-m-d H:i:s'):'';


        $lista = Asistencia::orderBy('created_at', 'DESC')
            ->where(function($x) use($fecha_init, $fecha_end) {
                if ($fecha_init!=='') {
                    $x->where('fecha', '>=', $fecha_init);
                }
                if ($fecha_end!=='') {
                    $x->where('fecha', '<=', $fecha_end);
                }
            })
            ->whereHas('empleado', function($q) use($personal) {
                if ($personal != '') {
                    $q->where('id', $personal);
                }
            })
            // ->get();
            ->paginate(10);

        // dd($lista);
        foreach ($lista as $item) {
            // formato de fecha
            $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
            $fecha = Carbon::parse(date($item->fecha));
            $mes = $meses[($fecha->format('n')) - 1];
            $item->fecha = $fecha->format('d') .'-'. $mes .'-'. $fecha->format('Y');

            $now = Carbon::parse($item->hora);
            $item->tmpHora = $now->format('g:i:s A');

            $now2 = Carbon::parse($item->horario);
            $item->tmpHorario = $now2->format('g:i:s A');
            // end formato fecha

            // diferencia
            $item->diferencia = $this->diffTiempos($item->horario, $item->hora);
        }

        $empleados = Empleado::orderBy('created_at', 'DESC')->get();

        // dd($lista);
        return view('asistencias.index')->with([
            'lista' => $lista,
            'empleados' => $empleados
        ]);
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
    function convertToHoursMins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    public function reportPdf(Request $request)
    {
        $personal = ($request->personal)??'';
        $fecha_init = ($request->fecha_init)?Carbon::parse($request->fecha_init)->format('Y-m-d H:i:s'):'';
        $fecha_end = ($request->fecha_end)?Carbon::parse($request->fecha_end)->format('Y-m-d H:i:s'):'';


        $lista = Asistencia::orderBy('created_at', 'DESC')
            ->where(function($x) use($fecha_init, $fecha_end) {
                if ($fecha_init!=='') {
                    $x->where('fecha', '>=', $fecha_init);
                }
                if ($fecha_end!=='') {
                    $x->where('fecha', '<=', $fecha_end);
                }
            })
            ->whereHas('empleado', function($q) use($personal) {
                if ($personal != '') {
                    $q->where('id', $personal);
                }
            })
            ->get();

        // dd($lista);
        foreach ($lista as $item) {
            // formato de fecha
            $meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
            $fecha = Carbon::parse(date($item->fecha));
            $mes = $meses[($fecha->format('n')) - 1];
            $item->fecha = $fecha->format('d') .'-'. $mes .'-'. $fecha->format('Y');
            // end formato fecha
        }
    
        $pdf = \PDF::loadView('asistencias.report-pdf', [
            'lista' => $lista
        ]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('factura_.pdf');

        // return view('asistencias.report-pdf', [
        //     'lista' => $lista
        // ]);
    }
}
