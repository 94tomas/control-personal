<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <style>
        /* auth */
        .wrap-auth {
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
            z-index: 0;
        }
        .wrap-auth::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(0, 28, 33, 0.8);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div id="app" class="wrapper wrap-auth" style="background-image: url('{{ asset('/img/bg-auth2.jpeg')}}')">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            {{-- <img class="animation__shake" src="{{ asset('/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60"> --}}
            <div class="animation__shake">Cargando...</div>
        </div>

        <!-- Main content -->
        <main class="d-flex justify-content-center align-items-center" style="min-height:100vh;">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
