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
                        <h1 class="m-0">Nuevo usuario</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/usuarios">Lista de usuarios</a></li>
                            <li class="breadcrumb-item active">Nuevo usuario</li>
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
                                <h3 class="card-title">Nuevo registro</h3>
                            </div>
                            <!-- /.card-header -->
    
                            <!-- form start -->
                            <form action="{{ route('nuevo-usuario') }}" method="post">
                                @csrf
                                <div class="card-body pb-1">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <h6>Datos personales</h6>
                                            <hr>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Nombre(s) *</label>
                                                <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" name="name" id="name" placeholder="Jose" value="{{ old('name') }}" required>
                                                @if($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="last_name">Apellido(s) *</label>
                                                <input type="text" class="form-control {{ ($errors->has('last_name')) ? 'is-invalid' : '' }}" name="last_name" id="last_name" placeholder="Perez" value="{{ old('last_name') }}" required>
                                                @if($errors->has('last_name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('last_name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="direction">{{ __('Dirección *') }}</label>
                                                <input id="direction" type="text" class="form-control @error('direction') is-invalid @enderror" name="direction" value="{{ old('direction') }}" required>
                    
                                                @error('direction')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Tel/Cel *') }}</label>
                                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                    
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="ci">{{ __('Número de identidad *') }}</label>
                                                <input id="ci" type="text" class="form-control @error('ci') is-invalid @enderror" name="ci" value="{{ old('ci') }}" required>
                    
                                                @error('ci')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
            
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="birthday">{{ __('Fecha de cumpleaños *') }}</label>
                                                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" name="birthday" value="{{ old('birthday') }}" max="1995-12-31" required>
                    
                                                @error('birthday')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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
                                                <label for="username">Nombre de usuario *</label>
                                                <input type="text" class="form-control {{ ($errors->has('username')) ? 'is-invalid' : '' }}" name="username" id="username" placeholder="pepe" value="{{ old('username') }}" required>
                                                @if($errors->has('username'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('username') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="email">Correo electrónico *</label>
                                                <input type="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                                                @if($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="password">Contraseña *</label>
                                                <input type="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" name="password" id="password" placeholder="********" value="{{ old('password') }}" required>
                                                @if($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('password') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="password-confirm">{{ __('Confirmar contraseña *') }}</label>
                                                <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Estado de cuenta</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="status" class="custom-control-input" id="status">
                                                    <label class="custom-control-label" for="status">Estado</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="role">Cargo/Rol *</label>
                                                <select class="form-control {{ ($errors->has('role')) ? 'is-invalid' : '' }}" name="role" id="role" required>
                                                    <option value="">- Seleccionar -</option>
                                                    <option value="superadmin" {{ (old('role')=='superadmin')?'selected':'' }}>SuperAdministrador</option>
                                                    <option value="admin" {{ (old('role')=='admin')?'selected':'' }}>Administrador</option>
                                                </select>
                                                @if($errors->has('role'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('role') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-right">
                                    <a href="/usuarios/lista" class="btn btn-secondary">Cancelar</a>
                                    <button type="submit" class="btn bg-primary">Registrar</button>
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
    <!-- /.content-wrapper -->

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#role').on('change', function() {
            if ($(this).val() == 'distributor') {
                $('#select_zone').removeClass('d-none');
                $('#zone').attr('required', true)
            } else {
                $('#select_zone').addClass('d-none');
                $('#zone').attr('required', false)
            }
        });
    });
</script>
@endsection
