@extends('vendedor.layout.main')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Resúmen de Pedido #{{ $orden->id }}</h4>
                <p class="category">Detalles del pedido #{{ $orden->id }}, para {{ $orden->client->name.' '.$orden->client->lastname }}</p>
            </div>
            <div class="card-content">
                  <h3>Status del Pedido</h3>
                  <div class="row">
                        <div class="col-md-2">
                              <label class="text-primary">Aprobado</label>
                              @if ($orden->approved)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Producción</label>
                              @if ($orden->production)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Recolección</label>
                              @if ($orden->recoger)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Entregado</label>
                              @if ($orden->entregado)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Facturado</label>
                              @if ($orden->facturado)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Cobrado</label>
                              @if ($orden->cobrado)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                              @endif
                        </div>
                  </div>
                  <h3>Cliente</h3>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Nombre Completo</label>
                              <p>{{ $orden->client->name.' '.$orden->client->lastname }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Fecha de Nacimiento</label>
                              <p>{{ Carbon\Carbon::parse($orden->client->birthday)->toFormattedDateString() }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Correo Electrónico</label>
                              <p><a href="mailto:{{ $orden->client->email }}">{{ $orden->client->email }}</a></p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Teléfono</label>
                              <p><a href="tel:{{ $orden->client->phone }}">{{ $orden->client->phone }}</a></p>
                        </div>
                  </div>
                  <h4>Facturación</h4>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary"></label>
                              <p></p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary"></label>
                              <p></p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary"></label>
                              <p></p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary"></label>
                              <p></p>
                        </div>
                  </div>
                  <h3>Saco</h3>
                  <h4>Saco Externo</h4>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Fit del Saco:</label>
                              <p>{{ App\Fit::find($orden->client->fit_saco)->name }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Talla del Saco:</label>
                              <p>{{ $orden->client->talla_saco }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Corte del Saco:</label>
                              <p>
                              @switch($orden->client->corte_saco)
                                    @case(1)
                                          First case...
                                          @break
                                    @case(2)
                                          pasdfpaosdjf
                                          @break
                                    @case(3)
                                          asodifjoasdijf
                                          @break
                                  @default
                                          Default case...
                              @endswitch
                              </p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Largo de Manga:</label>
                              <p>{{ $orden->client->largo_manga }}</p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Largo de Espalda:</label>
                              <p>{{ $orden->client->largo_espalda }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Tipo de Tela</label>
                              <p>{{ $orden->tela_isco ? 'Tela de ISCO' : 'Tela del Cliente' }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Código de la Tela</label>
                              <p>{{ $orden->codigo_tela }}</p>
                        </div>
                        @if (!$orden->tela_isco)
                              <div class="col-md-3">
                                    <label class="text-primary">Metros de Tela:</label>
                                    <p>{{ $orden->mts_tela_cliente }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Código de Color Tela:</label>
                                    <p>{{ $orden->codigo_color_tela_cliente }}</p>
                              </div>
                        @endif
                        <div class="col-md-3">
                              <label class="text-primary">Tipo de Forro</label>
                              <p>{{ $orden->forro_isco ? 'Forro del Cliente' : 'Forro de ISCO' }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Código de Forro</label>
                              <p>{{ $orden->codigo_forro }}</p>
                        </div>
                        @if (!$orden->forro_isco)
                              <div class="col-md-3">
                                    <label class="text-primary">Código de Color de Forro:</label>
                                    <p>{{ $orden->codigo_color_forro_cliente }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label  class="text-primary">Metros de Forro:</label>
                                    <p>{{ $orden->mts_forro_cliente }}</p>
                              </div>
                        @endif
                  </div>
                  <h4>Saco Interno</h4>
                  <div class="row">
                        <div class="col-md-12">
                              <label class="text-primary">Notas del Saco:</label>
                              <p>{{ $orden->client->notas_saco }}</p>
                        </div>
                  </div>
                  <h4>Pantalón</h4>
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ url('/vendedor/ordenes') }}" class="btn btn-info">Regresar</a>
            <a href="#" class="btn btn-warning">Exportar a PDF</a>
	</div>
</div>
@endsection