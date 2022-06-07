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
                        <h1 class="m-0">Nuevo rol</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/roles/lista">Lista de roles</a></li>
                            <li class="breadcrumb-item active">Nuevo rol</li>
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
                            <form action="{{ route('nuevo-rol') }}" method="post">
                                @csrf
                                <div class="card-body pb-1">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Nombre del rol *</label>
                                                <input type="text" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" name="name" id="name" placeholder="admin" value="{{ old('name') }}" required>
                                                @if($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="description">Descripción *</label>
                                                <input type="text" class="form-control {{ ($errors->has('description')) ? 'is-invalid' : '' }}" name="description" id="description" placeholder="Administrador" value="{{ old('description') }}" required>
                                                @if($errors->has('description'))
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $errors->first('description') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-right">
                                    <a href="/roles/lista" class="btn btn-secondary">Cancelar</a>
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
        //
    });
</script>
@endsection
