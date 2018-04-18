@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Detalles de {{$validador->name.' '.$validador->lastname}}</h4>
                <p class="category">Análisis e información del Validador #{{$validador->id}}</p>
            </div>
            <div class="card-content">
                <h4>Información del Validador</h4>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Nombre Completo</label>
                        <p>{{ $validador->name.' '.$validador->lastname }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Email</label>
                        <p>{{ $validador->email }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Teléfono</label>
                        <p>{{ $validador->phone }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Cumpleaños</label>
                        <p>{{ $validador->birthday }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Posición dentro de ISCO</label>
                        <p>{{ $validador->job_position }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Estado de Validador</label>
                        <p>{{ $validador->enabled ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                </div>
                <a href="{{ url('/admin/validadores') }}" class="btn btn-default">Regresar</a>
            </div>
        </div>
    </div>
</div>
@endsection