@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            {{ __('Nuevo registro') }}
                        </div>
                        <div class="col-4 text-right">
                            <a href="/personal">Volver</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre completo">
                        </div>
                        <div class="form-group">
                            <label for="cargo">Cargo</label>
                            <input type="text" class="form-control" id="cargo" placeholder="Cargo">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
