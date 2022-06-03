@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Registrar</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/personal/lista">Empleados</a></li>
                        <li class="breadcrumb-item active">Nuevo empleado</li>
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
                            <h3 class="card-title">Nuevo empleado</h3>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form action="{{ route('nuevo-personal') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nombres" class="col-sm-2 col-form-label">Nombre(s)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control {{ ($errors->has('nombres')) ? 'is-invalid' : '' }}" name="nombres" id="nombres" placeholder="Juan" value="{{ old('nombres') }}">
                                        @if($errors->has('nombres'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('nombres') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="apellidos" class="col-sm-2 col-form-label">Apellido(s)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control {{ ($errors->has('apellidos')) ? 'is-invalid' : '' }}" name="apellidos" id="apellidos" placeholder="Perez" value="{{ old('apellidos') }}">
                                        @if($errors->has('apellidos'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('apellidos') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control {{ ($errors->has('direccion')) ? 'is-invalid' : '' }}" name="direccion" id="direccion" placeholder="Av. Prado San Clemente" value="{{ old('direccion') }}">
                                        @if($errors->has('direccion'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('direccion') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_cel" class="col-sm-2 col-form-label">Tel/cel</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control {{ ($errors->has('tel_cel')) ? 'is-invalid' : '' }}" name="tel_cel" id="tel_cel" placeholder="61326565" value="{{ old('tel_cel') }}">
                                        @if($errors->has('tel_cel'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('tel_cel') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Fecha nacimiento</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control {{ ($errors->has('fecha_nacimiento')) ? 'is-invalid' : '' }}" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="15/01/1990" value="{{ old('fecha_nacimiento') }}" max="1995-12-31">
                                        @if($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('fecha_nacimiento') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="genero" class="col-sm-2 col-form-label">Género</label>
                                    <div class="col-sm-10">
                                        <select class="select2 form-control {{ ($errors->has('genero')) ? 'is-invalid' : '' }}" name="genero" id="genero">
                                            <option value="">- Seleccionar -</option>
                                            <option value="hombre" {{ (old('genero')=='hombre')?'selected':'' }}>Hombre</option>
                                            <option value="mujer" {{ (old('genero')=='mujer')?'selected':'' }}>Mujer</option>
                                        </select>
                                        @if($errors->has('genero'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('genero') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="cargo_id" class="col-sm-2 col-form-label">Cargo</label>
                                    <div class="col-sm-10">
                                        <select class="select2 form-control {{ ($errors->has('cargo_id')) ? 'is-invalid' : '' }}" name="cargo_id" id="cargo_id">
                                            <option value="">- Seleccionar -</option>
                                            @foreach ($cargos as $cg)
                                            <option value="{{ $cg->id }}" {{ (old('cargo_id')==$cg->id)?'selected':'' }}>
                                                {{ $cg->nombre_cargo }} - {{ $cg->descripcion }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('cargo_id'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('cargo_id') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="horarios" class="col-sm-2 col-form-label">Horario</label>
                                    <div class="col-sm-10">
                                        <select class="select2 form-control {{ ($errors->has('horarios')) ? 'is-invalid' : '' }}" name="horarios[]" id="horarios" multiple data-placeholder="- Seleccionar -">
                                            @foreach ($horarios as $hr)
                                            <option value="{{ $hr->id }}" {{ (old('horarios')==$hr->id)?'selected':'' }}>
                                                @php
                                                    echo $hr->titulo.': ' .$hr->hora_inicio. ' - ' .$hr->hora_fin;
                                                @endphp
                                            </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('horarios'))
                                            <span class="invalid-feedback" role="alert">
                                                {{ $errors->first('horarios') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right">
                                <a href="/personal/lista" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Registrar</button>
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

@section('scripts')
<script>
    $(function () {
        $('.select2').select2()
    });
</script>
@endsection
