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
                  <h4>Datos Generales</h4>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Número de Orden</label>
                              <p>{{ $orden->id }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Fecha de Creación</label>
                              <p>{{ $orden->created_at }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Fecha de Última Modificación</label>
                              <p>{{ $orden->updated_at }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Vendedor</label>
                              <p>#{{ $orden->vendedor->id.' - '.$orden->vendedor->name.' '.$orden->vendedor->lastname }}</p>
                        </div>
                  </div>
                  <h4>Estado General</h4>
                  <div class="row">
                        <div class="col-md-2">
                              @if ($orden->approved)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Aprobado</label>
                                    <br>
                                    {{ $orden->date_approved }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Aprobado</label>
                              @endif
                        </div>
                        <div class="col-md-2">
                              @if ($orden->production)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Producción</label>
                                    <br>
                                    {{ $orden->date_production }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Producción</label>
                              @endif
                        </div>
                        <div class="col-md-2">
                              @if ($orden->pickup)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Recolección</label>
                                    <br>
                                    {{ $orden->date_pickup }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Recolección</label>
                              @endif
                        </div>
                        <div class="col-md-2">
                              @if ($orden->delivered)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Entregado</label>
                                    <br>
                                    {{ $orden->date_delivered }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Entregado</label>
                              @endif
                        </div>
                        <div class="col-md-2">
                              @if ($orden->facturado)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Facturado</label>
                                    <br>
                                    {{ $orden->date_facturado }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Facturado</label>
                              @endif
                        </div>
                        <div class="col-md-2">
                              @if ($orden->cobrado)
                                    <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                    <label class="text-primary">Cobrado</label>
                                    <br>
                                    {{ $orden->date_cobrado }}
                              @else
                                    <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                    <label class="text-primary">Cobrado</label>
                              @endif
                        </div>
                  </div>
                  @if ($orden->production)
                        <h4>Estado de Producción</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    @if ($orden->corte)
                                          <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                          <label class="text-primary">Corte</label>
                                          <br>
                                          {{ $orden->date_corte }}
                                    @else
                                          <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                          <label class="text-primary">Corte</label>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    @if ($orden->ensamble)
                                          <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                          <label class="text-primary">Ensamble</label>
                                          <br>
                                          {{ $orden->date_ensamble }}
                                    @else
                                          <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                          <label class="text-primary">Ensamble</label>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    @if ($orden->plancha)
                                          <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                          <label class="text-primary">Plancha</label>
                                          <br>
                                          {{ $orden->date_plancha }}
                                    @else
                                          <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                          <label class="text-primary">Plancha</label>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    @if ($orden->revision)
                                          <i class="fa fa-check-circle fa-lg text-success" aria-hidden="true"></i>
                                          <label class="text-primary">Revisión</label>
                                          <br>
                                          {{ $orden->date_revision }}
                                    @else
                                          <i class="fa fa-times-circle fa-lg text-danger" aria-hidden="true"></i>
                                          <label class="text-primary">Revisión</label>
                                    @endif
                              </div>
                        </div>
                  @endif
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
                              <label class="text-primary">R.F.C</label>
                              <p>{{ $orden->client->rfc }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Dirección de Facturación</label>
                              <p>{{ $orden->client->address_legal }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Banco</label>
                              <p>{{ $orden->client->bank }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Últimos 4 dígitos de la Cuenta</label>
                              <p>{{ $orden->client->account_digits }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Concepto de Facturación</label>
                              <p>{{ $orden->client->concept }}</p>
                        </div>
                  </div>
                  @if ($orden->has_coat)
                        <h3>Saco</h3>
                        <h4>Saco Externo</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Solapa</label>
                                    <p>{{ $orden->coat->tipo_solapa }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Ojal en Solapa</label>
                                    <p>{{ $orden->coat->tipo_ojal_solapa }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color en Ojal Solapa</label>
                                    <p>{{ $orden->coat->color_ojal_solapa }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Botones de Frente</label>
                                    <p>{{ $orden->coat->botones_frente }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Aberturas Detrás</label>
                                    <p>{{ $orden->coat->aberturas_detras }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Botones Mangas</label>
                                    <p>{{ $orden->coat->botones_mangas }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Ojal en Manga</label>
                                    <p>{{ $orden->coat->tipo_ojal_manga }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Ojal en Manga</label>
                                    <p>{{ $orden->coat->color_ojal_manga }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Posición Ojal en Manga</label>
                                    <p>{{ $orden->coat->posicion_ojal_manga }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Ojales Activos en Manga</label>
                                    <p>{{ $orden->coat->ojales_activos_manga }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Bolsas Exteriores</label>
                                    <p>{{ $orden->coat->tipo_bolsas_ext }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">PickStitch</label>
                                    <p>{{ $orden->coat->pickstitch ? 'Si' : 'No' }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">PickStitch en Filos</label>
                                    <p>{{ $orden->coat->pickstitch_filos ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">PickStitch en Aletilla</label>
                                    <p>{{ $orden->coat->pickstitch_aletilla ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">PickStitch en Cartera</label>
                                    <p>{{ $orden->coat->pickstitch_cartera }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Sin Aletilla</label>
                                    <p>{{ $orden->coat->sin_aletilla ? 'Sin Aletilla' : 'Con Aletilla' }}</p>
                              </div>
                        </div>
                        <h4>Saco Interno</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Vista</label>
                                    <p>{{ $orden->coat->tipo_vista }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Forro Interno Mangas</label>
                                    <p>
                                          @if ($orden->coat->balsam_rayas)
                                                Balsam a Rayas
                                          @else
                                                {{ $orden->coat->forro_interno_mangas }}
                                          @endif
                                    </p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Pin Point Interno</label>
                                    <p>{{ $orden->coat->pin_point_interno ? 'Si' : 'No' }}</p>
                              </div>
                              @if ($orden->coat->pin_point_interno)                        
                                    <div class="col-md-3">
                                          <label class="text-primary">Color de Pin Point</label>
                                          <p>{{ $orden->coat->pin_point_interno_color }}</p>
                                    </div>
                                    <div class="col-md-3">
                                          <label class="text-primary">Código de Pin Point</label>
                                          <p>{{ $orden->coat->pin_point_interno_codigo }}</p>
                                    </div>
                              @endif
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Bies</label>
                                    <p>{{ $orden->coat->bies ? 'Si' : 'No' }}</p>
                              </div>
                              @if ($orden->coat->bies)
                                    <div class="col-md-3">
                                          <label class="text-primary">Color de Bies</label>
                                          <p>{{ $orden->coat->bies_color }}</p>
                                    </div>
                                    <div class="col-md-3">
                                          <label class="text-primary">Código de Bies</label>
                                          <p>{{ $orden->coat->bies_codigo }}</p>
                                    </div>
                              @endif
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Puntada</label>
                                    <p>{{ $orden->coat->puntada_color }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Bolsas Internas</label>
                                    <p>{{ $orden->coat->bolsas_int }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Bolsas Internas</label>
                                    <p>{{ $orden->coat->bolsa_int_color }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Vivos de Bolsas Internas</label>
                                    <p>
                                          @if ($orden->coat->vivos_bolsas_internas_cuerpo)
                                                Vivos igual a los seleccionados en el cuerpo
                                          @else
                                                {{ $orden->coat->otro_vivos_bolsas_internas }}
                                          @endif
                                    </p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Puntada en Filos</label>
                                    <p>{{ $orden->coat->puntada_filos ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Puntada en Aletillas</label>
                                    <p>{{ $orden->coat->puntada_aletillas ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Puntada en Carteras</label>
                                    <p>{{ $orden->coat->puntada_carteras ? 'Si' : 'No' }}</p>
                              </div>
                        </div>
                  @endif
                  @if ($orden->has_vest)
                        <h3>Chaleco</h3>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Cuello</label>
                                    <p>{{ $orden->vest->tipo_cuello }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Bolsas</label>
                                    <p>{{ $orden->vest->tipo_bolsas }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Espalda</label>
                                    <p>{{ $orden->vest->tipo_espalda }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Ajustador en la Espalda</label>
                                    <p>{{ $orden->vest->ajustador_espalda ? 'Si' : 'No' }}</p>
                              </div>
                        </div>
                  @endif
                  @if ($orden->has_pants)
                        <h3>Pantalón</h3>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Con Pase</label>
                                    <p>{{ $orden->pants->pase ? 'Con Pase' : 'Sin Pase' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Número de Pliegues</label>
                                    <p>{{ $orden->pants->pliegues }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Bolsas Traseras</label>
                                    <p>{{ $orden->pants->bolsas_traseras }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Vivo</label>
                                    <p>{{ $orden->pants->tipo_vivo }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Ojalera</label>
                                    <p>{{ $orden->pants->color_ojalera }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Medio Forro</label>
                                    <p>{{ $orden->pants->color_medio_forro }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Dobladillo</label>
                                    <p>{{ $orden->pants->dobladillo }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Pretina</label>
                                    <p>{{ $orden->pants->pretina }}</p>
                              </div>

                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Pretina</label>
                                    <p>{{ $orden->pants->color_pretina }}</p>
                              </div>
                        </div>
                  @endif
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ url('/vendedor/ordenes') }}" class="btn btn-info">Regresar</a>
            <a href="{{ url('/vendedor/ordenes/'.$orden->id.'/pdf') }}" class="btn btn-warning">Exportar a PDF</a>
	</div>
</div>
@endsection