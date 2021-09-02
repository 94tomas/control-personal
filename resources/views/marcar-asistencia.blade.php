@extends('layouts.auth')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 offset-md-4 offset-sm-3">
            {{-- mensaje al usuario --}}
            @include('layouts.partials.alertas')
            {{-- fin mensaje al usuario --}}
            <div class="card card-secondary">
                <div class="card-header text-center">
                    <h4 class="mb-0" id="hora">
                        00:00:00
                    </h4>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-sm-3 col-md-4"></div> --}}
        <div class=" col-12 col-sm-6 col-md-4 offset-md-4 offset-sm-3">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('marcar') }}">
                        @csrf
                        <input type="hidden" id="h_hora" name="hora">
                        <div class="form-group">
                            <label for="cod_empleado">{{ __('Código de empleado') }}</label>
                            <input id="cod_empleado" type="text" class="form-control @error('cod_empleado') is-invalid @enderror" name="cod_empleado" value="{{ old('cod_empleado') }}" required autofocus>

                            @error('cod_empleado')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-sm-3 col-md-4"></div> --}}
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#cod_empleado').keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });
        setInterval(showTime, 1000);
    });
    function showTime() {
        var d = new Date();
        var hr = d.getHours();
        var min = (d.getMinutes() < 10) ? '0'+d.getMinutes() : d.getMinutes();
        var seg = (d.getSeconds() < 10) ? '0'+d.getSeconds() : d.getSeconds();
        var time = hr + ':' + min + ':' + seg;
        $('#hora').html(time)
        $('#h_hora').val(time)
    }
</script>
@endsection
