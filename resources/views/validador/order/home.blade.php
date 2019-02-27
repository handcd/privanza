@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a href="{{ url('/validador/ordenes/agregar') }}" class="btn btn-success btn-large"><i class="material-icons">add</i>Añadir nueva orden</a>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="orange">
                <h4 class="title">Órdenes sin aprobar</h4>
                <p class="category">Pedidos pendientes por validar</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($noAprobadas as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/validador/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary">$2,380</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/validador/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/validador/ordenes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs">
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Órdenes aprobadas</h4>
                <p class="category">Pedidos por entrar a producción</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($aprobadas as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/validador/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary">$2,380</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/validador/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
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
                <h4 class="title">Todas las órdenes</h4>
                <p class="category">Pedidos aprobados y por aprobar</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/validador/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary">$2,380</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/validador/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>                                
                                @if( !$orden->approved )
                                    <a href="{{ url('/validador/ordenes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs">
                                        <i class="material-icons">edit</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection