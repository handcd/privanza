@extends('vendedor.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/vendedor/citas/agregar') }}"><i class="material-icons">add</i>Agregar una cita</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Citas el día de hoy</h4>
                <p class="category">Lista de citas que tienes programadas para hoy {{ Carbon\Carbon::now()->toFormattedDateString() }}</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha/Hora</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @forelse ($eventosHoy as $evento)
                        <tr>
                            <td>{{ $evento->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name }}</td>
                            <td>{{ $evento->fechahora }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/citas/'.$evento->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                @if (!Carbon\Carbon::parse($evento->fechahora)->isPast())
                                     <a href="{{ url('/vendedor/citas/'.$evento->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        	<tr>
                        		<td colspan="4" class="text-center">Al parecer no tienes citas el día de hoy :(</td>
                        	</tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Citas de la Semana</h4>
                <p class="category">Lista de citas que tienes programadas para la semana {{ Carbon\Carbon::now()->weekOfYear }} del año.</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha/Hora</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @forelse ($eventosSemana as $evento)
                        <tr>
                            <td>{{ $evento->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name }}</td>
                            <td>{{ $evento->fechahora }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/citas/'.$evento->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                @if (!Carbon\Carbon::parse($evento->fechahora)->isPast())
                                     <a href="{{ url('/vendedor/citas/'.$evento->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        	<tr>
                        		<td colspan="4" class="text-center">Al parecer no tienes citas esta semana :(</td>
                        	</tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todas las citas</h4>
                <p class="category">Lista con todas las citas que se han registrado en el sistema</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha/Hora</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @forelse ($eventos as $evento)
                        <tr>
                            <td>{{ $evento->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name }}</td>
                            <td>{{ $evento->fechahora }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/citas/'.$evento->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                @if (!Carbon\Carbon::parse($evento->fechahora)->isPast())
                                     <a href="{{ url('/vendedor/citas/'.$evento->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        	<tr>
                        		<td colspan="4" class="text-center">Al parecer no tienes citas registradas :(</td>
                        	</tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection