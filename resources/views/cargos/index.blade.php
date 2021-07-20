@extends('layouts.app')

@section('content')

<div class="content-wrapper pb-3">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Cargos</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Cargos</li>
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
                    <a href="/cargos/nuevo" class="btn btn-primary">Nuevo</a>
                    <div class="card-tools mr-0">
                        <div class="input-group input-group-sm mt-1" style="width: 250px;">
                          <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar">

                          <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>Cargo</th>
                                <th>Tipo tarifa</th>
                                <th>Tarifa</th>
                                <th>Estado</th>
                                <th style="width: 50px" class="text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{ $item->nombre_cargo }}</td>
                                <td>
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
                                <td>{{ $item->tarifa }}</td>
                                <td>
                                    @if ($item->estado)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="/cargos/editar/{{ $item->id }}" class="btn btn-primary btn-xs" style="width:25px;">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs" style="width:25px;" data-toggle="modal" data-target="#delModal" data-id="{{ $item->id }}">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
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

<!-- Modal -->
<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="alert alert-danger" style="display:none"></div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-body pb-1">
                    <h5 class="modal-title">¿Desea continuar?</h5>
                    El cargo se eliminará permanentente del sistema
                </div>
            </div>
            <form action="" method="post">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Si, eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#delModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('id') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-content form').attr('action', `${window.location.protocol}//${window.location.hostname}/cargos/${recipient}`)
        })
    });
</script>
@endsection