@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Detalles del Vendedor</h4>
                <p class="category">Análisis e información del vendedor #12</p>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td class="col-md-4"><strong>Nombre:</strong></td>
                                <td class="col-md-8">{{$vendedor->name}} {{$vendedor->lastname}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><strong>Correo Electrónico:</strong></td>
                                <td class="col-md-8"><a href="mailto:{{$vendedor->email}}">{{$vendedor->email}}</a></td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><strong>Teléfono:</strong></td>
                                <td class="col-md-8"><a href="tel:{{$vendedor->phone}}">{{$vendedor->phone}}</a></td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><strong>Dirección:</strong></td>
                                <td class="col-md-8">{{$vendedor->address}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><strong>Fecha de Registro:</strong></td>
                                <td class="col-md-8">{{$vendedor->created_at}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-4"><strong>Última Actualización de Información:</strong></td>
                                <td class="col-md-8">{{$vendedor->updated_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h4>Órdenes ingresadas por el vendedor:</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Cotiazción</th>
                        </thead>
                        <tbody>
                            @foreach ($vendedor->orders as $order)
                                <tr>
                                    <td><a href="{{ url('/validador/ordenes/'.$order->id) }}">{{$order->id}}</a></td>
                                    <td><a href="{{ url('/validador/clientes/'.$order->client->id) }}">{{ $order->client->name }}</a></td>
                                    <td>{{ $order->approved ? 'Aprobada' :  'Sin Aprobar' }}</td>
                                    <td>{{ $order->precio }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{ url('/validador/vendedores') }}" class="btn btn-default">Regresar</a>
            </div>
        </div>
    </div>
</div>
@endsection