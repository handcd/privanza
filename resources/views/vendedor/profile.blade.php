@extends('vendedor.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title"> Tus datos {{ $vendedor->name }}</h4>
                <p class="category">Aquí está tu información, con ella te contactaremos para cualquier situación. Corrobora que sea correcta.</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Información General</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">Nombre completo:</label>
                        <p>{{ $vendedor->name.' '.$vendedor->lastname }}</p>
                    </div>
                    <div class="col-md-8">
                        <label class="text-primary">Domicilio</label>
                        <p>{{ $vendedor->address_home }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">Email</label>
                        <p><a href="mailto:{{ $vendedor->email }}">{{ $vendedor->email }}</a></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Teléfono de contacto</label>
                        <p><a href="tel:{{ $vendedor->phone }}">{{ $vendedor->phone }}</a></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Fecha de Cumpleaños</label>
                        <p>{{ $vendedor->birthday }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Información de Facturación</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">R.F.C.</label>
                        <p>{{ $vendedor->rfc ? $vendedor->rfc : 'No ha sido cargado al sistema' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Últimos Dígitos de la Cuenta</label>
                        <p>{{ $vendedor->account_digits ? $vendedor->account_digits : 'No ha sido cargado al sistema' }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Banco</label>
                        <p>{{ $vendedor->bank ? $vendedor->bank : 'No ha sido cargado al sistema' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Concepto de Facturación</label>
                        <p>{{ $vendedor->concept ? $vendedor->concept : 'No ha sido cargado al sistema' }}</p>
                    </div>
                </div>
                <a href="{{ url('/vendedor/perfil/solicitarCambio') }}" class="btn btn-primary pull-right">Solicitar cambio de información</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection