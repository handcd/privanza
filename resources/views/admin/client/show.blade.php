@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Detalles del Cliente</h4>
                <p class="category">Detalles del cliente #{{ $client->id }}</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Datos Generales</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">Nombre Completo:</label>
                        <p>{{ $client->name.' '.$client->lastname }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Correo Electrónico:</label>
                        <p><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Teléfono</label>
                        <p><a href="tel:{{ $client->phone }}">{{ $client->phone }}</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">Fecha de Nacimiento:</label>
                        <p>{{ Carbon\Carbon::parse($client->birthday)->toDateString() }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Dirección de Visita:</label>
                        <p>{{ $client->address_visit }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Dirección de Entregas:</label>
                        <p>{{ $client->address_delivery }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Datos de Facturación</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">RFC:</label>
                        <p>{{ $client->rfc }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Banco:</label>
                        <p>{{ $client->bank }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Últimos 4 dígitos de la cuenta:</label>
                        <p>{{ $client->account_digits }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="text-primary">Dirección de Facturación:</label>
                        <p>{{ $client->address_legal}}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="text-primary">Concepto de Facturación:</label>
                        <p>{{ $client->concept }}</p>
                    </div>
                </div>
                <h4>Vendedor Asignado</h4>
                <div class="row">
                    <div class="col-md-1">
                        <label class="text-primary">ID</label>
                        <p>{{ $client->vendedor->id }}</p>
                    </div>
                    <div class="col-md-3">
                        <label class="text-primary">Nombre</label>
                        <p>{{ $client->vendedor->name.' '.$client->vendedor->lastname }}</p>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ url('/admin/vendedores/'.$client->vendedor->id) }}" class="btn btn-info">Ver Vendedor</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Referencia</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="text-primary">Contacto que lo trajo:</label>
                        <p>{{ $client->contacto }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Notas del Cliente</h4>
                        <p>{{ $client->notes ? $client->notes : '(Sin notas).' }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Pedidos del Cliente</h4>
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <th>#</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @forelse ($client->orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>${{ $order->precio }}</td>
                                    <td class="td-actions text-center">
                                        <a href="{{ url('/admin/ordenes/'.$order->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="3">No hay pedidos de este cliente :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Citas con el Cliente</h4>
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                @forelse ($client->events as $event)
                                <tr>
                                    <td>{{ $event->id }}</td>
                                    <td>{{ Carbon\Carbon::parse($event->fechahora)->toDateString() }}</td>
                                    <td class="td-actions text-center">
                                        <a href="{{ url('/admin/citas/'.$event->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="3">No hay citas con este cliente :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <a href="{{ url('/admin/clientes') }}" class="btn btn-default">Regresar</a>
            </div>
        </div>
    </div>
</div>
@endsection