@extends('layouts.app')

@section('content')

<div class="content-wrapper pb-3">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Horarios</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Horarios</li>
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
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <a href="/horarios/nuevo" class="btn btn-lg bg-primary d-block">Nuevo</a>
                        </div>
                        <div class="col-12 col-md-10 d-flex align-items-end">
                            <div style="width:100%" class="d-flex">
                                <div class="ml-auto">
                                    <a href="/horarios-pdf" target="_blank" class="btn bg-red">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>Horario</th>
                                <th>Hora inicio</th>
                                <th>Hora fin</th>
                                {{-- <th>Hora descanso</th> --}}
                                {{-- <th>Hora fin descanso</th> --}}
                                <th>Estado</th>
                                <th style="width: 50px" class="text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lista as $item)
                            <tr>
                                <td>{{ $item->titulo }}</td>
                                <td>{{ $item->hora_inicio }}</td>
                                <td>{{ $item->hora_fin }}</td>
                                {{-- <td>{{ $item->hora_descanso }}</td>
                                <td>{{ $item->hora_fin_descanso }}</td> --}}
                                <td>
                                    @if ($item->estado)
                                    <span class="badge bg-success">Activo</span>
                                    @else
                                    <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <!-- Default dropleft button -->
                                    <div class="btn-group dropleft">
                                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <div class="dropdown-menu">
                                            <!-- Dropdown menu links -->
                                            <a class="dropdown-item" href="/horarios/editar/{{ $item->id }}">Editar</a>
                                            <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->id }}">Eliminar</a>
                                        </div>
                                    </div>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-body pb-1">
                    <h5 class="modal-title">¿Desea continuar?</h5>
                    El horario se eliminará permanentente del sistema
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
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('id') // Extract info from data-* attributes
            var modal = $(this)
            modal.find('.modal-content form').attr('action', `${window.location.protocol}//${window.location.hostname}/horarios/${recipient}`)
        })
    });
</script>
@endsection
