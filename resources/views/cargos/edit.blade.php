@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Editar</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/cargos/lista">Cargos</a></li>
                        <li class="breadcrumb-item active">Editar cargo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12 col-md-10 offset-md-1">
                    <!-- general form elements -->
                    <div class="card card-secondary mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Editar cargo</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form action="{{ route('editar-cargo', ['id'=>$cargo->id]) }}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="nombre_cargo">Nombre del cargo</label>
                                            <input value="{{ $cargo->nombre_cargo }}" type="text" class="form-control {{ ($errors->has('nombre_cargo')) ? 'is-invalid' : '' }}" name="nombre_cargo" id="nombre_cargo" placeholder="Encargado(a) de Activos fijos">
                                            @if($errors->has('nombre_cargo'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('nombre_cargo') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="descripcion">Descripción</label>
                                            <textarea class="form-control {{ ($errors->has('descripcion')) ? 'is-invalid' : '' }}" name="descripcion" id="descripcion" rows="3" placeholder="Encargado(a) de manejos de apeles del area de almacen">{{ $cargo->descripcion }}</textarea>
                                            @if($errors->has('descripcion'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('descripcion') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="tipo">Tipo tarifa</label>
                                            <select class="form-control {{ ($errors->has('tipo')) ? 'is-invalid' : '' }}" name="tipo" id="tipo">
                                                <option value="">- Seleccionar -</option>
                                                <option value="por_hora" {{ ($cargo->tipo=='por_hora')?'selected':'' }}>Hora</option>
                                                <option value="por_semana" {{ ($cargo->tipo=='por_semana')?'selected':'' }}>Semana</option>
                                                <option value="por_mes" {{ ($cargo->tipo=='por_mes')?'selected':'' }}>Mes</option>
                                                <option value="por_anio" {{ ($cargo->tipo=='por_anio')?'selected':'' }}>Año</option>
                                            </select>
                                            @if($errors->has('tipo'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('tipo') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="tarifa">Tarifa</label>
                                            <input type="number" min="1" step="0.1" class="form-control {{ ($errors->has('tarifa')) ? 'is-invalid' : '' }}" name="tarifa" id="tarifa" placeholder="3000" value="{{ $cargo->tarifa }}">
                                            @if($errors->has('tarifa'))
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('tarifa') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                @php
                                                    $ifCheck = ($cargo->estado==1)?'checked="checked"':''
                                                @endphp
                                                <input {{ $ifCheck }} type="checkbox" class="custom-control-input" id="estado" name="estado">
                                                <label class="custom-control-label" for="estado">Estado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right">
                                <a href="/cargos/lista" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>


        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>

@endsection