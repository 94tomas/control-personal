@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="m-0">Nuevo registro</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Nuevo registro</li>
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
                        <form>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nombres" class="col-sm-2 col-form-label">Nombre(s)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nombres" placeholder="Nombre(s)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="apellidos" class="col-sm-2 col-form-label">Apellido(s)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="apellidos" placeholder="Apellido(s)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="direccion" placeholder="Dirección">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_cel" class="col-sm-2 col-form-label">Tel/cel</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="tel_cel" placeholder="Tel/cel">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Cumpleaños</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="fecha_nacimiento" placeholder="Fecha de nacimiento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-2 col-form-label">Género</label>
                                    <div class="col-sm-10">
                                        <select class="form-control">
                                            <option>- Seleccionar -</option>
                                            <option>Hombre</option>
                                            <option>Mujer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer text-right">
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
