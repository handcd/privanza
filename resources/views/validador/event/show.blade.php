@extends('vendedor.layout.main')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Cita del {{ Carbon\Carbon::parse($evento->fechahora)->toDayDateTimeString() }}</h4>
                <p class="category">Detalles de la cita agendada.</p>
            </div>
            <div class="card-content">
            	<div class="row">
            		<div class="col-md-4">
            			<label class="text-primary">Fecha de la Cita:</label>
            			<p>{{ Carbon\Carbon::parse($evento->fechahora)->toFormattedDateString() }}</p>
            		</div>
            		<div class="col-md-2">
            			<label class="text-primary">Hora de la Cita:</label>
            			<p>{{ Carbon\Carbon::parse($evento->fechahora)->format('g:i a') }}</p>
            		</div>
                        <div class="col-md-6">
                              <label class="text-primary">Notas de la Cita:</label>
                              <p>{{ $evento->notes }}</p>
                        </div>
            	</div>
            	<div class="row">
            		<div class="col-md-12">
            			<h4>Información del Cliente</h4>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-4">
            			<label class="text-primary">Nombre de Cliente</label>
            			<p><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name.' '.$evento->client->lastname }}</a></p>
            		</div>
            		<div class="col-md-2">
            			<label for="" class="text-primary">Edad</label>
            			<p>{{ Carbon\Carbon::parse($evento->client->birthday)->diffInYears(Carbon\Carbon::now()) }} años</p>
            		</div>
            		<div class="col-md-6">
            			<label for="" class="text-primary">Dirección de Visita</label>
            			<p>{{ $evento->client->address_visit }}</p>
            		</div>
            	</div>
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ url('/vendedor/citas') }}" class="btn btn-info">Regresar</a>
	</div>
</div>
@endsection