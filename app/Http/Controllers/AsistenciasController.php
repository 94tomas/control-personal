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
            // end formato fecha

            // Hora de entrada
            // $hrEntrada = $item->empleado->horario->hora_inicio;
            // $hrSalida = $item->empleado->horario->hora_fin;

            // $descansoIni = $item->empleado->horario->hora_descanso;
            // $descansoFin = $item->empleado->horario->hora_fin_descanso;

            // $toleranciaIni = $item->empleado->horario->tolerancia_inicio;
            // $toleranciaFin = $item->empleado->horario->tolerancia_fin;
            // dd($item->empleado->horario);
            // end Hora de entrada
        }

        $empleados = Empleado::orderBy('created_at', 'DESC')->get();

        // dd($lista);
        return view('asistencias.index')->with([
            'lista' => $lista,
            'empleados' => $empleados
        ]);
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
