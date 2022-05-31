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
                        <p><strong>Cargos: </strong>Todos</p>
                    </td>
                    <td style="text-align:center; width:33.333%;"><h2>Lista de Cargos</h2></td>
                    <td></td>
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
                    <th style="text-align:left;">CARGO</th>
                    <th style="text-align:center;">TIPO TARIFA</th>
                    <th style="text-align:center;">TARIFA</th>
                    <th style="text-align:right;">ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $item)
                    <tr>
                        <td style="border: 1px solid;">{{ $item->nombre_cargo }}</td>
                        <td style="text-align:center; border: 1px solid;">
                            @switch($item->tipo)
                                @case('por_hora')
                                    Por hora
                                    @break
                                @case('por_semana')
                                    Semanal
                                    @break
                                @case('por_mes')
                                    Mensual
                                    @break
                                @case('por_anio')
                                    Anual
                                    @break
                                @default
                                    @break
                            @endswitch
                        </td>
                        <td style="text-align:center; border: 1px solid;">{{ $item->tarifa }}</td>
                        <td style="text-align: right; border: 1px solid;">
                            @if ($item->estado)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
