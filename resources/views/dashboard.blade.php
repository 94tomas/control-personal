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
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Dashboard</li>
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
                    <div class="col-lg-3 col-sm-6 col-12">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $data['users'] }}</h3>
                
                                <p>Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="/usuarios/lista" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                    
                    <div class="col-lg-3 col-sm-6 col-12">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $data['employee'] }}</h3>
                
                                <p>Personal</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="/personal/lista" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                    
                    <div class="col-lg-3 col-sm-6 col-12">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $data['hours'] }}</h3>
                
                                <p>Horarios</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <a href="/horarios/lista" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-lg-3 col-sm-6 col-12">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $data['charges'] }}</h3>
                
                                <p>Cargos</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <a href="/cargos/lista" class="small-box-footer">Ver más <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

</div>

@endsection
