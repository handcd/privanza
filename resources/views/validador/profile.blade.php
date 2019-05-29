@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">{{ $validador->name }}</h4>
                <p class="category">Aquí está tu información, con ella te contactaremos para cualquier situación. Corrobora que sea correcta.</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Nombre Completo</label>
                        <p>{{ $validador->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Posición en TAILORED</label>
                        <p>{{ $validador->job_position }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Email</label>
                        <p><a href="mailto:{{ $validador->email }}">{{ $validador->email }}</a></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Teléfono de contacto</label>
                        <p><a href="tel:{{ $validador->phone }}">{{ $validador->phone }}</a></p>
                    </div>
                </div>
                <a href="{{ url('/validador/perfil/solicitarCambio') }}" class="btn btn-primary pull-right">Solicitar cambio de información</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection