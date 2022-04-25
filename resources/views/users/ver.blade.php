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
                        <h1 class="m-0">Usuario {!! $user->name !!} {!! $user->last_name !!}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/usuarios">Lista de usuarios</a></li>
                            <li class="breadcrumb-item active">{!! $user->name !!} {!! $user->last_name !!}</li>
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

                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1">
                        <!-- general form elements -->
                        <div class="card card-secondary mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Detalle del usuario</h3>
                            </div>
                            <!-- /.card-header -->
    
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <h6>Datos personales</h6>
                                        <hr>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Nombre(s)</label><br>
                                            {{ $user->name }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="last_name">Apellido(s)</label><br>
                                            {{ $user->last_name }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="direction">Dirección</label><br>
                                            {{ $user->direction }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Tel/Cel</label><br>
                                            {{ $user->phone }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="ci">Número de identidad</label><br>
                                            {{ $user->ci }}{{ ($user->extension)?'-'.$user->extension : '' }}
                                        </div>
                                    </div>
        
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="birthday">Fecha de nacimiento</label><br>
                                            {{ $user->birthday }}
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <h6 class="my-3">Datos de cuenta</h6>
                                        <hr>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="username">Nombre de usuario</label><br>
                                            {{ $user->username }}
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Correo electrónico</label><br>
                                            {{ $user->email }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label>Estado de cuenta</label><br>
                                            {{ ($user->status)?'activo':'inactivo' }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="form-group">
                                            <label for="role">Cargo/Rol</label><br>
                                            {!! $user->roles[0]->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-right">
                                <a href="/usuarios/lista" class="btn btn-secondary">Atras</a>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>

@endsection
