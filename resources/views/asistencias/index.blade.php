@extends('layouts.app')

@section('content')

<div class="content-wrapper pb-3">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Asistencia</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Asistencia</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="card card-secondary">
                <div class="card-header">
                    <form action="">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="form-group input-group-sm mb-0">
                                    <label for="personal">Seleccionar personal</label>
                                    <select class="form-control" id="personal" name="personal">
                                        <option value="">- Todos -</option>
                                        @foreach ($empleados as $item)
                                        <option value="{!! $item->id !!}" {{ (Request::get('personal')==$item->id)?'selected':'' }}>{!! $item->cod_empleado !!} - {!! $item->nombres.' '.$item->apellidos !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-sm-3 col-md-2">
                                <div class="form-group input-group-sm mb-0">
                                    <label for="fecha_init">F. Inicio</label>
                                    <input type="date" class="form-control" id="fecha_init" name="fecha_init" value="{{ Request::get('fecha_init') }}">
                                </div>
                            </div>
                            <div class="col-6 col-sm-3 col-md-2">
                                <div class="form-group input-group-sm mb-0">
                                    <label for="fecha_end">F. Final</label>
                                    <input type="date" class="form-control" id="fecha_end" name="fecha_end" value="{{ Request::get('fecha_end') }}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 d-flex align-items-end">
                                <div style="width:100%" class="d-flex">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                    <div class="ml-auto">
                                        <a href="javascript:;" id="report_pdf" class="btn bg-red">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        </a>
                                        {{-- <a href="javascript:;" id="report_excel" class="btn bg-green">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Código</th>
                                <th>Personal</th>
                                <th>Horario del personal</th>
                                <th>Hora de registro</th>
                                <th>Tolerancia</th>
                                <th class="text-right">Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                                <tr>
                                    <td>
                                        {!! $item->fecha !!}
                                    </td>
                                    <td>
                                        {!! $item->empleado->cod_empleado !!}
                                    </td>
                                    <td>
                                        {!! $item->empleado->apellidos.' '.$item->empleado->nombres !!}
                                    </td>
                                    <td>
                                        {!! $item->tmpHorario !!}
                                    </td>
                                    <td>
                                        {!! $item->tmpHora !!}
                                    </td>
                                    <td>
                                        10 mins
                                    </td>
                                    <td class="text-right">
                                        {!! $item->diferencia !!}
                                        @if ($item->diferencia)
                                            @switch($item->descriptionDiff)
                                                @case('tarde')
                                                    <span class="badge bg-gray">Tarde</span>
                                                    @break
                                                @case('antes')
                                                    <span class="badge bg-success">Antes</span>
                                                    @break
                                                @default
                                                    @break
                                            @endswitch
                                        @else
                                            <span class="badge bg-info">Puntual</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix {{ ($lista->lastPage() <= 1)?'d-none' : ''}}">
                    <?php
                    // config
                    $link_limit = 5; // maximum number of links (a little bit inaccurate, but will be ok for now)
                    ?>
                    @if ($lista->lastPage() > 1)
                        <ul class="pagination m-0 float-right">
                            <li class="page-item{{ ($lista->currentPage() == 1) ? ' disabled' : '' }}">
                                <a href="{{ $lista->url(1) }}" class="page-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
                            </li>
                            <li class="page-item{{ ($lista->currentPage() == 1) ? ' disabled' : '' }}">
                                <a href="{{ $lista->url($lista->currentPage()-1) }}" class="page-link"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                            </li>
                            @for ($i = 1; $i <= $lista->lastPage(); $i++)
                                <?php
                                $half_total_links = floor($link_limit / 2);
                                $from = $lista->currentPage() - $half_total_links;
                                $to = $lista->currentPage() + $half_total_links;
                                if ($lista->currentPage() < $half_total_links) {
                                $to += $half_total_links - $lista->currentPage();
                                }
                                if ($lista->lastPage() - $lista->currentPage() < $half_total_links) {
                                    $from -= $half_total_links - ($lista->lastPage() - $lista->currentPage()) - 1;
                                }
                                ?>
                                @if ($from < $i && $i < $to)
                                    <li class="page-item{{ ($lista->currentPage() == $i) ? ' active' : '' }}">
                                        <a href="{{ $lista->url($i) }}" class="page-link">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                            <li class="page-item{{ ($lista->currentPage() == $lista->lastPage()) ? ' disabled' : '' }}">
                                <a href="{{ $lista->url($lista->currentPage()+1) }}" class="page-link"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                            </li>
                            <li class="page-item{{ ($lista->currentPage() == $lista->lastPage()) ? ' disabled' : '' }}">
                                <a href="{{ $lista->url($lista->lastPage()) }}" class="page-link"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>

@endsection

@section('scripts')
<script>
    $(function () {
        function GetURLParameter(sParam) {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) 
            {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) 
                {
                    return sParameterName[1];
                }
            }
        }

        $('#report_pdf').on('click', function() {
            var Url = window.location.href;
            var personal = GetURLParameter('personal');
            var fecha_init = GetURLParameter('fecha_init');
            var fecha_end = GetURLParameter('fecha_end');
            window.open(
                `/asistencias-pdf?personal=${personal??''}&fecha_init=${fecha_init??''}&fecha_end=${fecha_end??''}`,
                '_blank' // <- This is what makes it open in a new window.
            );
        });
        $('#report_excel').on('click', function() {
            var Url = window.location.href;
            var personal = GetURLParameter('personal');
            var fecha_init = GetURLParameter('fecha_init');
            var fecha_end = GetURLParameter('fecha_end');
            window.open(
                `/asistencias-excel?personal=${personal??''}&fecha_init=${fecha_init??''}&fecha_end=${fecha_end??''}`,
                '_blank' // <- This is what makes it open in a new window.
            );
        });
    });
</script>
@endsection
