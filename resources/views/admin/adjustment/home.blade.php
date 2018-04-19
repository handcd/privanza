@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/admin/ajustes/agregar') }}"><i class="material-icons">add</i>Añadir nuevo Ajuste</a>
    </div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header" data-background-color="red">
				<h4 class="title">Órdenes de Ajustes Sin Aprobar</h4>
				<p class="category">Órdenes de AJustes que no han sido aprobadas</p>
			</div>
			<div class="card-content table-responsive">
				<table class="table table-hover">
					<thead>
						<th>#</th>
						<th>Cliente</th>
						<th class="text-center">Consecutivo de Ajuste</th>
						<th class="text-center">Consecutivo de Orden de Producción</th>
						<th>Acciones</th>
					</thead>
					<tbody>
						@forelse ($sinAprobar as $orden)
						<tr>
							<td>{{ $orden->id }}</td>
							<td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
							<td class="text-center">{{ $orden->consecutivo_ajuste }}</td>
							<td class="text-center">{{ $orden->consecutivo_op }}</td>
							<td class="td-actions text-right">
                                <a href="{{ url('/admin/ajustes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden de Ajustes" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/ajustes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden de Ajustes" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
						</tr>
						@empty
						<tr>
							<td class="text-center" colspan="5">No hay Órdenes de Ajustes sin Aprobar ¡Hurra!</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				<div class="row text-center">
                    {{ $sinAprobar->appends([
                    	'aprobadas' => $aprobadas->currentPage(),
                    	'ordenes' => $ordenes->currentPage(),
                    	'finalizadas' => $finalizadas->currentPage()
                    ])->links() }}
                </div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header" data-background-color="orange">
				<h4 class="title">Órdenes de Ajustes Aprobadas (En Proceso)</h4>
				<p class="category">Órdenes de AJustes que están Aprobadas y se encuentran en producción en planta.</p>
			</div>
			<div class="card-content table-responsive">
				<table class="table table-hover">
					<thead>
						<th>#</th>
						<th>Cliente</th>
						<th class="text-center">Consecutivo de Ajuste</th>
						<th class="text-center">Consecutivo de Orden de Producción</th>
						<th>Acciones</th>
					</thead>
					<tbody>
						@forelse ($aprobadas as $orden)
						<tr>
							<td>{{ $orden->id }}</td>
							<td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
							<td class="text-center">{{ $orden->consecutivo_ajuste }}</td>
							<td class="text-center">{{ $orden->consecutivo_op }}</td>
							<td class="td-actions text-right">
                                <a href="{{ url('/admin/ajustes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden de Ajustes" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/ajustes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden de Ajustes" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
						</tr>
						@empty
						<tr>
							<td class="text-center" colspan="5">No hay Órdenes de Ajustes en Producción por el momento.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				<div class="row text-center">
                    {{ $aprobadas->appends([
                    	'sinAprobar' => $sinAprobar->currentPage(),
                    	'ordenes' => $ordenes->currentPage(),
                    	'finalizadas' => $finalizadas->currentPage()
                    ])->links() }}
                </div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="card">
			<div class="card-header" data-background-color="green">
				<h4 class="title">Órdenes de Ajustes Finalizadas</h4>
				<p class="category">Órdenes de AJustes que han finalizado su proceso de producción.</p>
			</div>
			<div class="card-content table-responsive">
				<table class="table table-hover">
					<thead>
						<th>#</th>
						<th>Cliente</th>
						<th class="text-center">Consecutivo de Ajuste</th>
						<th class="text-center">Consecutivo de Orden de Producción</th>
						<th>Acciones</th>
					</thead>
					<tbody>
						@forelse ($finalizadas as $orden)
						<tr>
							<td>{{ $orden->id }}</td>
							<td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
							<td class="text-center">{{ $orden->consecutivo_ajuste }}</td>
							<td class="text-center">{{ $orden->consecutivo_op }}</td>
							<td class="td-actions text-right">
                                <a href="{{ url('/admin/ajustes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden de Ajustes" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/ajustes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden de Ajustes" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
						</tr>
						@empty
						<tr>
							<td class="text-center" colspan="5">No hay Órdenes de Ajustes finalizadas, por ahora.</td>
						</tr>
						@endforelse
					</tbody>
				</table>
				<div class="row text-center">
                    {{ $finalizadas->appends([
                    	'aprobadas' => $aprobadas->currentPage(),
                    	'sinAprobar' => $sinAprobar->currentPage(),
                    	'ordenes' => $ordenes->currentPage()
                    ])->links() }}
                </div>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todas las Órdenes de Ajustes</h4>
                <p class="category">Lista general de Órdenes de Ajustes ingresadas al sistema</p>
            </div>
            <div class="card-content table-responsive">
                <div class="col-md-6">
                    <input id="filter" class="form-control" type="text" placeholder="Buscar Orden de Ajustes...">
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Cliente</th>
                        <th class="text-center">Consecutivo de Ajuste</th>
                        <th class="text-center">Consecutivo de Orden de Producción</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody class="searchable">
                        @forelse ($ordenes as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/admin/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</a></td>
                            <td class="text-center">{{ $orden->consecutivo_ajuste }}</td>
                            <td class="text-center">{{ $orden->consecutivo_op }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/ajustes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden de Ajustes" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/ajustes/'.$orden->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden de Ajustes" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="6">No hay Órdenes de Ajustes registradas en el sistema :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $ordenes->appends([
                    	'aprobadas' => $aprobadas->currentPage(),
                    	'sinAprobar' => $sinAprobar->currentPage(),
                    	'finalizadas' => $finalizadas->currentPage()
                    ])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#filter').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        })(jQuery);
    });
</script>
@endsection