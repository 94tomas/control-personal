@extends('layouts.app')

@section('content')

<div class="content-wrapper pb-3">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Nómina de empleados</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Nómina de empleados</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            {{-- mensaje al usuario --}}
            @include('layouts.partials.alertas')
            {{-- fin mensaje al usuario --}}

            <div class="card card-secondary">
                <div class="card-header">
                    Empleados
                    <div class="card-tools mr-0">
                        <div class="ml-auto">
                            <a href="/nomina-pdf" target="_blank" class="btn bg-red">
                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Empleado</th>
                                <th>Cargo</th>
                                <th>Horario</th>
                                <th>Tarífa</th>
                                <th class="text-right">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{ $item->cod_empleado }}</td>
                                <td>{{ $item->nombres }} {{ $item->apellidos }}</td>
                                <td>{{ $item->cargo->nombre_cargo }}</td>
                                <td>{{ $item->horario->hora_inicio }} - {{ $item->horario->hora_fin }}</td>
                                <td>
                                    {{ $item->cargo->tarifa }}/Bs. 
                                    @switch($item->cargo->tipo)
                                        @case('por_hora')
                                            Jornal
                                            @break
                                        @case('por_semana')
                                            Semanal
                                            @break
                                        @case('por_mes')
                                            Mensual
                                            @break
                                        @default
                                            Anual
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-right">
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

{{-- @section('scripts')
<script>
    $(document).ready(function(){
        $('#removeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('id') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-content form').attr('action', `${window.location.protocol}//${window.location.hostname}/personal/${recipient}`)
        })
    });
</script>
@endsection --}}
