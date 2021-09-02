@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Hay algunos errores<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Aviso de informacion --}}
@if (session('info'))
    <div class="alert alert-info">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('info') }}
    </div>
@endif

{{-- Aviso de todo okey --}}
@if (session('ok'))
    <div class="alert alert-success">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('ok') }}
    </div>
@endif

{{-- Aviso de error --}}
@if (session('error'))
    <div class="alert alert-danger">
    	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ session('error') }}
    </div>
@endif