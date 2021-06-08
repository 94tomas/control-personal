@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            {{ __('Personal') }}
                        </div>
                        <div class="col-4 text-right">
                            <a href="/personal/create" class="btn btn-primary">Nuevo</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    lista de personal
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
