@extends('vendedor.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session()->has('msg'))
            <div class="alert alert-success fade in">
                <div class="container-fluid">
                    <div class="alert-icon">
                        <i class="material-icons">check</i>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true"><i class="material-icons">clear</i></span>
                    </button>
                    <b>Aviso:</b> {{ session('msg') }}
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">{{ $vendedor->name }}</h4>
                <p class="category">Aquí está tu información, con ella te contactaremos para cualquier situación. Corrobora que sea correcta.</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Datos de contacto.</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Nombre completo:</label>
                        <p>{{ $vendedor->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Domicilio</label>
                        <p>{{ $vendedor->address }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Email</label>
                        <p><a href="mailto:{{ $vendedor->email }}">{{ $vendedor->email }}</a></p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Teléfono de contacto</label>
                        <p><a href="tel:{{ $vendedor->phone }}">{{ $vendedor->phone }}</a></p>
                    </div>
                </div>
                <a href="{{ url('/vendedor/perfil/solicitarCambio') }}" class="btn btn-primary pull-right">Solicitar cambio de información</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection