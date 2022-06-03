<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asistencia</title>
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
        }
        p {
            margin-bottom: 4px;
            margin-top: 0px
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
            /* border-top: 1px solid black; */
        }
        table {
            width: 100%;
        }
        tr td {
            padding: 5px 5px;
            font-size: 13px;
        }
        tr th {
            background:#343a40;
            padding: 5px 5px;
            color: white;
            font-size: 12px;
        }
        .mt-10 {
            margin-top: 100px;
        }
        .text-center {
            text-align: center;
            align-content: center;
        }
        img {
            max-width: 100px;
            object-fit: contain;
            object-position: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <div>
        <table style="margin-bottom: 10px">
            <tbody>
                <tr>
                    <td style="vertical-align:top; width:33.333%;">
                        <p><strong>Empleado(s): </strong> {{ (Request::get('personal'))?($lista[0]->empleado->apellidos.' '.$lista[0]->empleado->nombres):'Todos' }}</p>
                    </td>
                    <td style="text-align:center; width:33.333%;"><h2>Reporte de asistencia</h2></td>
                    <td style="text-align:right; vertical-align:top; width:33.333%;">
                        Fecha<br>
                        @php
                            $fecha = (Request::get('fecha_end')) ? (Request::get('fecha_init').' - '.Request::get('fecha_end')) : Request::get('fecha_init');
                        @endphp
                        <strong>{{ (Request::get('fecha_init') || Request::get('fecha_end'))?$fecha:'Todas las fechas' }}</strong>
                    </td>
                </tr>
                <tr>
                    {{-- <td>Fecha: {{ $data->date }}</td> --}}
                </tr>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
        {{-- details --}}
        <table style="border: 1px solid black">
            <thead>
                <tr>
                    <th style="text-align:left;">FECHA</th>
                    <th style="text-align:center;">CÓDIGO</th>
                    <th style="text-align:center;">PERSONAL</th>
                    <th style="text-align:center;">HORARIO DEL PERSONAL</th>
                    <th style="text-align:center;">HORA DE REGISTRO</th>
                    <th style="text-align:center;">TOLERANCIA</th>
                    <th style="text-align:right;">REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $item)
                    <tr>
                        <td style="border: 1px solid;">
                            {!! $item->fecha !!}
                        </td>
                        <td style="text-align:center; border: 1px solid;">
                            {!! $item->empleado->cod_empleado !!}
                        </td>
                        <td style="text-align:center; border: 1px solid;">
                            {!! $item->empleado->apellidos.' '.$item->empleado->nombres !!}
                        </td>
                        <td style="text-align:center; border: 1px solid;">
                            {!! $item->tmpHorario !!}
                        </td>
                        <td style="text-align:center; border: 1px solid;">
                            {!! $item->tmpHora !!}
                        </td>
                        <td style="text-align:center; border: 1px solid;">
                            10 mins
                        </td>
                        <td style="text-align: right; border: 1px solid;">
                            {!! $item->diferencia !!}
                            @switch($item->descriptionDiff)
                                @case('tarde')
                                    <span style="background-color:#6c757d; color:#fff; padding: 0.25em 0.4em;">Tarde</span>
                                    @break
                                @case('antes')
                                    <span style="background-color:#28a745; color:#fff; padding: 0.25em 0.4em;">Antes</span>
                                    @break
                                @default
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
