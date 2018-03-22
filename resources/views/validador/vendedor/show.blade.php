@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Detalles de {{$vendedor->name.' '.$vendedor->lastname}}</h4>
                <p class="category">Análisis e información del vendedor #{{$vendedor->id}}</p>
            </div>
            <div class="card-content">
                <h4>Información del Vendedor</h4>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Nombre Completo</label>
                        <p>{{ $vendedor->name.' '.$vendedor->lastname }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Email</label>
                        <p>{{ $vendedor->email }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Teléfono</label>
                        <p>{{ $vendedor->phone }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Cumpleaños</label>
                        <p>{{ $vendedor->birthday }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Dirección de Casa</label>
                        <p>{{ $vendedor->address_home }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Tipo de Vendedor</label>
                        <p>{{ $vendedor->type == 0 ? 'Interno de ISCO' : 'Externo a ISCO'}}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Estado de Vendedor</label>
                        <p>{{ $vendedor->enabled ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                </div>
                <h4>Datos Fiscales</h4>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Dirección Fiscal</label>
                        <p>{{ $vendedor->address_legal }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">RFC</label>
                        <p>{{ $vendedor->rfc }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Últimos 4 dígitos de la cuenta</label>
                        <p>{{ $vendedor->account_digits }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Concepto</label>
                        <p>{{ $vendedor->concept }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label class="text-primary">Banco</label>
                        <p>{{ $vendedor->bank }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Órdenes ingresadas por el vendedor:</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Status</th>
                                    <th>Cotiazción</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($vendedor->orders as $order)
                                        <tr>
                                            <td><a href="{{ url('/validador/ordenes/'.$order->id) }}">{{$order->id}}</a></td>
                                            <td><a href="{{ url('/validador/clientes/'.$order->client->id) }}">{{ $order->client->name }}</a></td>
                                            <td>
                                                @switch($order->currentStatus())
                                                    @case('facturado')
                                                        Facturado
                                                        @break
                                                    @case('cobrado')
                                                        Cobrado
                                                        @break
                                                    @case('delivered')
                                                        Entregado
                                                        @break
                                                    @case('pickup')
                                                        Listo para recolección
                                                        @break
                                                    @case('revision')
                                                        Producción: Revisión
                                                        @break
                                                    @case('plancha')
                                                        Producción: Plancha
                                                        @break
                                                    @case('ensamble')
                                                        Producción: Ensamble
                                                        @break
                                                    @case('corte')
                                                        Producción: Corte
                                                        @break
                                                    @case('production')
                                                        Producción
                                                        @break
                                                    @case('approved')
                                                        Aprobado
                                                        @break
                                                    @default
                                                        Sin Aprobar
                                                @endswitch
                                                
                                            </td>
                                            <td>{{ $order->precio }}</td>
                                            <td class="td-actions text-right">
                                                <a href="{{ url('/validador/ordenes/'.$order->id) }}" type="button" rel="tooltip" title="Ver Pedido" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">remove_red_eye</i>
                                                </a>
                                                 <a href="{{ url('/validador/ordenes/'.$order->id.'/editar') }}" type="button" rel="tooltip" title="Editar Pedido" class="btn btn-primary btn-simple btn-xs">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Citas del Vendedor:</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($vendedor->events as $event)
                                        <tr>
                                            <td><a href="{{ url('/validador/citas/'.$event->id) }}">{{$event->id}}</a></td>
                                            <td><a href="{{ url('/validador/clientes/'.$event->client->id) }}">{{ $event->client->name }}</a></td>
                                            <td>{{ $event->fechahora }}</td>
                                            <td class="td-actions text-right">
                                                <a href="{{ url('/validador/citas/'.$event->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                                    <i class="material-icons">remove_red_eye</i>
                                                </a>
                                                 <a href="{{ url('/validador/citas/'.$event->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/validador/vendedores') }}" class="btn btn-default">Regresar</a>
            </div>
        </div>
    </div>
</div>
@endsection