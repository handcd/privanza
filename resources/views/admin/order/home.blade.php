@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a href="{{ url('/admin/ordenes/agregar') }}" class="btn btn-success btn-large"><i class="material-icons">add</i>Añadir nueva orden</a>
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
                            <td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary"> ${{ $orden->precio }} </td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/ordenes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $noAprobadas->appends([
                            'aprobadas' => $aprobadas->currentPage(),
                            'recoger' => $listosEntrega->currentPage(),
                            'entregados' => $entregados->currentPage(),
                            'facturados' => $facturados->currentPage(),
                            'cobrados' => $cobrados->currentPage(),
                            'general' => $ordenes->currentPage()
                        ])->links() }}
                </div>
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
                            <td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary">${{ $orden->precio }} </td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $aprobadas->appends([
                            'noAprobadas' => $noAprobadas->currentPage(),
                            'recoger' => $listosEntrega->currentPage(),
                            'entregados' => $entregados->currentPage(),
                            'facturados' => $facturados->currentPage(),
                            'cobrados' => $cobrados->currentPage(),
                            'general' => $ordenes->currentPage()
                        ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="red">
                <h4 class="title">Pedidos por Recoger</h4>
                <p class="category">Pedidos listos para ser recogidos para su entrega</p>
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
                        @forelse ($listosEntrega as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
                            <td class="text-primary">${{ $orden->precio }}</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No tienes órdenes listas para recoger :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $listosEntrega->appends([
                            'aprobadas' => $aprobadas->currentPage(),
                            'noAprobadas' => $noAprobadas->currentPage(),
                            'entregados' => $entregados->currentPage(),
                            'facturados' => $facturados->currentPage(),
                            'cobrados' => $cobrados->currentPage(),
                            'general' => $ordenes->currentPage()
                        ])->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Pedidos Entregados</h4>
                <p class="category">Pedidos entregados del proceso de compra, producción, entrega, facturación y cobro.</p>
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
                        @forelse ($entregados as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
                            <td class="text-primary">${{ $orden->precio }}</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No tienes órdenes listas para recoger :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $entregados->appends([
                            'aprobadas' => $aprobadas->currentPage(),
                            'noAprobadas' => $noAprobadas->currentPage(),
                            'recoger' => $listosEntrega->currentPage(),
                            'facturados' => $facturados->currentPage(),
                            'cobrados' => $cobrados->currentPage(),
                            'general' => $ordenes->currentPage()
                        ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@if (Auth::user()->type == 0)
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Pedidos Cobrados</h4>
                    <p class="category">Pedidos tuyos que han sido cobrados</p>
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
                            @forelse ($cobrados as $orden)
                            <tr>
                                <td>{{ $orden->id }}</td>
                                <td><a href="{{ url('/vendedor/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
                                <td class="text-primary">${{ $orden->precio }}</td>
                                <td>{{ $orden->created_at }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ url('/vendedor/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                        <i class="material-icons">remove_red_eye</i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No tienes órdenes listas para recoger :(</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row text-center">
                        {{ $cobrados->appends([
                                'aprobadas' => $aprobadas->currentPage(),
                                'noAprobadas' => $noAprobadas->currentPage(),
                                'recoger' => $listosEntrega->currentPage(),
                                'entregados' => $entregados->currentPage(),
                                'facturados' => $facturados->currentPage(),
                                'general' => $ordenes->currentPage()
                            ])->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="green">
                    <h4 class="title">Pedidos Facturados</h4>
                    <p class="category">Pedidos tuyos que han sido facturados por ISCO.</p>
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
                            @forelse ($facturados as $orden)
                            <tr>
                                <td>{{ $orden->id }}</td>
                                <td><a href="{{ url('/vendedor/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
                                <td class="text-primary">${{ $orden->precio }}</td>
                                <td>{{ $orden->created_at }}</td>
                                <td class="td-actions text-right">
                                    <a href="{{ url('/vendedor/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                        <i class="material-icons">remove_red_eye</i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No tienes órdenes listas para recoger :(</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row text-center">
                        {{ $facturados->appends([
                                'aprobadas' => $aprobadas->currentPage(),
                                'noAprobadas' => $noAprobadas->currentPage(),
                                'recoger' => $listosEntrega->currentPage(),
                                'entregados' => $entregados->currentPage(),
                                'cobrados' => $cobrados->currentPage(),
                                'general' => $ordenes->currentPage()
                            ])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
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
                        <th>C-OP</th>
                        <th></th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }} {{ $orden->client->lastname}}</td>
                            @if( $orden->precio && $orden->consecutivo_op || $orden->precio && !$orden->consecutivo_op || !$orden->precio && $orden->consecutivo_op)
                                <td class="text-primary">                                 
                                    ${{ $orden->precio }}
                                </td>
                                <td>
                                    {{ $orden->consecutivo_op }}                                
                                </td>
                                <td>
                                    <div class="col-sm-12" style="float: right;">
                                        <a href="{{ url('/admin/ordenes/'.$orden->id.'/editar') }}" class="btn btn-success btn-large"><i class="material-icons">add</i>Editar Precio/C-OP</a>
                                    </div>
                                </td>

                            @elseif( !$orden->precio && !$orden->consecutivo_op )
                                <td colspan="2">
                                    <div class="col-sm-12" style="float: right;">
                                        <a href="{{ url('/admin/ordenes/'.$orden->id.'/editar') }}" class="btn btn-success btn-large"><i class="material-icons">add</i>Agregar Precio/C-OP</a>
                                    </div>
                                </td>
                                <td></td>
                            @endif
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>                                
                                @if( !$orden->approved )
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs">
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