@extends('layouts.app')

@section('content')

<div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Lista de usuarios</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Lista de usuarios</li>
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
                        <form action="">
                            <div class="row">
                                <div class="col-12 col-md-2 pt-2">
                                    <a href="/usuarios/nuevo" class="btn btn-lg bg-primary d-block">Nuevo</a>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group input-group-sm mb-0">
                                        <label for="search">Buscar</label>
                                        <input type="text" name="search" class="form-control" placeholder="Buscar usuario" value="{{ (Request::get('search'))??'' }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 d-flex align-items-end">
                                    <div style="width:100%" class="d-flex">
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                        <div class="ml-auto">
                                            <a href="JAVASCRIPT:;" id="report_pdf" class="btn bg-red">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            </a>
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
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Estado</th>
                                    <th style="width: 50px" class="text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lista as $item)
                                <tr>
                                    <td>{!! $item->username !!}</td>
                                    <td>{!! $item->name.' '.$item->last_name !!}</td>
                                    <td>
                                        @foreach ($item->roles as $rol)
                                            {!! $rol->description !!}
                                        @endforeach
                                    </td>
                                    {{-- <td>{!! ($item->zone->name)??'' !!}</td> --}}
                                    <td>
                                        @if ($item->status)
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
                                                <a class="dropdown-item" href="/usuarios/{{ $item->id }}">Ver</a>
                                                <a class="dropdown-item" href="/usuarios/editar/{{ $item->id }}">Editar</a>
                                                <a class="dropdown-item" href="javascript:;" onclick="if(confirm('El usuario será eliminado permanentemente del sistema, ¿Desea continuar?')){event.preventDefault(); document.getElementById('form_delete_{{ $item->id }}').submit();}">Eliminar</a>
                                                <form id="form_delete_{{ $item->id }}" action="{{ route('delete-user', $item->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                </form>
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
    <!-- /.content-wrapper -->

</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
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
            var search = GetURLParameter('search');
            var role = GetURLParameter('role');
            window.open(
                `/usuarios-pdf?search=${search??''}&role=${role??''}`,
                '_blank' // <- This is what makes it open in a new window.
            );
        });
    });
</script>
@endsection
