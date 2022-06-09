<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ControlPersonal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/img/user-default.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fa fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-tachometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/roles/lista" class="nav-link {{ Request::is('roles/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-shield"></i>
                        <p>Roles del sistema</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/usuarios/lista" class="nav-link {{ Request::is('usuarios/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Usuarios del sistema</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/asistencias" class="nav-link {{ Request::is('asistencias') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>Asistencia</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/personal/lista" class="nav-link {{ Request::is('personal/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-users"></i>
                        <p>Personal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/horarios/lista" class="nav-link {{ Request::is('horarios/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-clock-o"></i>
                        <p>Horarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/cargos/lista" class="nav-link {{ Request::is('cargos/*') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-briefcase"></i>
                        <p>Cargos</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/nomina" class="nav-link {{ Request::is('nomina') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-list"></i>
                        <p>Nómina</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
