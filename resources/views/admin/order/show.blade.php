@extends('admin.layout.main')

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
                  {{--<form action="{{ url('/admin/ordenes/'.$orden->id) }}"  onsubmit=" return confirm('¿La información que deseas registrar es correcta?');">
                        {{method_field('PUT')}}
                        {{ csrf_field() }}
                        <div class="row">
                              <div class="col-md-3 col-md-offset-2">
                                    @if(!$orden->precio)
                                          <div class="input-group">
                                                <div class="form-group label-floating">
                                                      <label class="control-label">Precio</label>
                                                      <input name="precio" type="text" class="form-control">
                                                </div>
                                          </div>
                                    @endif
                              </div>
                              <div class="col-md-3">                                   
                                    @if(!$orden->consecutivo_op)
                                          <div class="input-group">
                                                <div class="form-group label-floating">
                                                      <label class="control-label">Consecutivo de operación</label>
                                                      <input name="consecutivo_op" type="text" class="form-control">
                                                </div>
                                          </div>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <input type='submit' class='btn btn-finish btn-fill btn-success'/>
                              </div>
                        </div>
                  </form>--}}
                  <h3>Estado General</h3>
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
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/aprobar') }}" class="btn btn-success">Aprobar</a>
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
                              @if ( $orden->approved && !$orden->production)
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/produccion') }}" class="btn btn-success">En producción</a>
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
                              @if( $orden->revision && !$orden->pickup)
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/recoleccion') }}" class="btn btn-success">En recolección</a>
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
                              @if( $orden->pickup && !$orden->delivered)
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/entrega') }}" class="btn btn-success">Entregado</a>
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
                              @if( $orden->delivered && !$orden->facturado)
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/factura') }}" class="btn btn-success">Facturado</a>
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
                              @if( $orden->facturado && !$orden->cobrado)
                                    <a href="{{ url('/admin/ordenes/'.$orden->id.'/cobro') }}" class="btn btn-success">Cobrado</a>
                              @endif
                        </div>
                  </div>
                  @if ($orden->production)
                        <h3>Estado de Producción</h3>
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
                                          <br>
                                          <a href="{{ url('/admin/ordenes/'.$orden->id.'/corte') }}" class="btn btn-success">Corte</a>
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
                                    <br>
                                    @if( $orden->corte && !$orden->ensamble)
                                          <a href="{{ url('/admin/ordenes/'.$orden->id.'/ensamble') }}" class="btn btn-success">Ensamble</a>
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
                                    <br>
                                    @if( $orden->ensamble && !$orden->plancha)
                                          <a href="{{ url('/admin/ordenes/'.$orden->id.'/plancha') }}" class="btn btn-success">Plancha</a>
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
                                    <br>
                                    @if( $orden->ensamble && !$orden->revision)
                                          <a href="{{ url('/admin/ordenes/'.$orden->id.'/revision') }}" class="btn btn-success">Revisión</a>
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
                  <h3>Medidas generales</h3>
                  <div class="row">
                        <div class="col-md-4">
                              <label class="text-primary">Altura</label>
                              <p>{{ $orden->client->altura  }} Cm.</p>
                        </div>
                        <div class="col-md-4">
                              <label class="text-primary">Peso</label>
                              <p>{{ $orden->client->peso }} Kg.</p>
                        </div>
                        <div class="col-md-4">
                              <label class="text-primary">Edad</label>
                              <p>{{ $orden->client->edad }} Años</p>
                        </div>
                        
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Abdomen</label>
                              @switch( $orden->client->abdomen )
                                    @case(0)
                                          <p>Delgado</p>
                                          @break
                                    @case(1)
                                          <p>Normal</p>
                                          @break
                                    @case(2)
                                          <p>Voluminoso</p>
                                          @break
                                    @default
                                          <p>Entrada inválida</p>
                              @endswitch

                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Pecho</label>
                              @switch( $orden->client->pecho )
                                    @case(0)
                                          <p>Musculoso</p>
                                          @break
                                    @case(1)
                                          <p>Normal</p>
                                          @break
                                    @case(2)
                                          <p>Curpulento</p>
                                          @break
                                    @default
                                          <p>Entrada inválida</p>
                              @endswitch
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Espalda</label>
                              @switch( $orden->client->esplada )
                                    @case(0)
                                          <p>Recta</p>
                                          @break
                                    @case(1)
                                          <p>Normal</p>
                                          @break
                                    @case(2)
                                          <p>Encorvada</p>
                                          @break
                                    @default
                                          <p>Entrada inválida</p>
                              @endswitch
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Tipo de hombros</label>
                              @switch( $orden->client->hombros )
                                    @case(0)
                                         <p>Rectos</p>
                                          @break
                                    @case(1)
                                          <p>Normales</p>
                                          @break
                                    @case(2)
                                          <p>Caídos</p>
                                          @break
                                    @default
                                          <p>Entrada inválida</p>
                              @endswitch
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-4">
                              <label class="text-primary">Contorno de cuello</label>
                              <p>{{ $orden->client->contornoCuello  }} pulgadas</p>
                        </div>
                        <div class="col-md-4">
                              <label class="text-primary">Contorno de biceps</label>
                              <p>{{ $orden->client->contornoBiceps }} pulgadas</p>
                        </div>
                        <div class="col-md-4">
                              <label class="text-primary">Medida Hombros</label>
                              <p>{{ $orden->client->medidaHombros }} pulgadas</p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Brazo derecho</label>
                              <p>{{ $orden->client->brazoDerecho }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Brazo izquierdo</label>
                              <p>{{ $orden->client->brazoIzquierdo }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Hombro derecho</label>
                              <p>{{ $orden->client->hombroDerecho }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Hombro izquierdo</label>
                              <p>{{ $orden->client->hombroIzquierdo }} pulgadas</p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Ancho de espalda</label>
                              <p>{{ $orden->client->anchoEspalda }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Largo de torso</label>
                              <p>{{ $orden->client->largoTorso }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Contorno de pecho</label>
                              <p>{{ $orden->client->contornoPecho }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Puño</label>
                              <p>{{ $orden->client->punio }} pulgadas</p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Contorno de Abdomen</label>
                              <p>{{ $orden->client->contornoAbdomen }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Contorno de cintura</label>
                              <p>{{ $orden->client->contornoCintura }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Contorno de cadera</label>
                              <p>{{ $orden->client->contornoCadera }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Largo de tiro</label>
                              <p>{{ $orden->client->largoTiro }} pulgadas</p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Largo interno de pantalón</label>
                              <p>{{ $orden->client->largoInternoPantalon }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Largo externo de pantalón</label>
                              <p>{{ $orden->client->largoExternoPantalon }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Contorno muslo</label>
                              <p>{{ $orden->client->contornoMuslo }} pulgadas</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Contorno rodilla</label>
                              <p>{{ $orden->client->contornoRodilla }} pulgadas</p>
                        </div>
                  </div>
                  <h3>Facturación</h3>
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
                  <h3>Datos de pedido</h3>
                  <div class="row">
                        <div class="col-md-2">
                              <label class="text-primary">Código de tela</label>
                              <p> {{ $orden->codigo_tela }} </p>
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Código de Forro</label>
                              <p> {{$orden->codigo_forro }}</p>
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Código de botones</label>
                              <p> {{$orden->codigo_botones }} </p>
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Color de botones</label>
                              <p> {{ $orden->color_botones }} </p>
                        </div>
                        <div class="col-md-2">
                              <label class="text-primary">Cantidad de botones</label>
                              <p> {{ $orden->cantidad_botones }} </p>
                        </div>
                  </div>
                  <div class="row">
                        <div class="col-md-3">
                              <label class="text-primary">Etiqueta de tela</label>
                              @if ($orden->etiquetas_tela === 1)
                                    <p> Sí. {{ $orden->marca_en_tela }} </p>
                              @else
                                    <p> Privanza </p>
                              @endif
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Etiqueta de marca</label>
                              @if ($orden->etiquetas_marca === 1)
                                    <p> Sí. {{ $orden->marca_en_etiqueta }}</p>
                              @else
                                    <p> Privanza </p>
                              @endif
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Gancho</label>
                              @if ($orden->gancho === 0)
                                    <p> Normal</p>
                              @elseif( $orden->gancho === 1)
                                    <p> Personalizado privanza </p>
                              @else
                                    <p>{{ $orden->gancho_personalizacion }}</p>                                    
                              @endif
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Portatrajes</label>
                              @if ($orden->portatrajes === 0)
                                    <p> Cubrepolvos </p>
                              @elseif( $orden->portatrajes === 1)
                                    <p> Personalizado privanza </p>
                              @else
                                    <p>{{ $orden->portatrajes_personalizacion }}</p>                                    
                              @endif
                        </div>
                        
                  </div>
                  <div class="row"> 
                        <div class="col-md-3">
                              <label class="text-primary">Nombre bordado</label>
                              <p>{{ $orden->bordado }}</p>
                        </div>                       
                        <div class="col-md-3">
                              <label class="text-primary">Tipo de Letra</label>
                              <p>{{ $orden->letra }}</p>
                        </div>
                        <div class="col-md-3">
                              <label class="text-primary">Color de bordado</label>
                              <p> {{ $orden->bordadoColor }} </p>
                        </div>
                  </div>
                  @if ($orden->has_coat)
                        <h3>Saco</h3>
                        <h4>Medidas de Cliente</h4>
                        <div class="row">

                              @if(isset($orden->coat))
                              <div class="col-md-3">
                                    <label class="text-primary">Fit deseado</label>
                                    <p>
                                    @switch($orden->coat->fit_id)
                                          @case(1)
                                                Especial. {{ $orden->coat->personalizacion_holgura_saco}} pulgadas de holgura.
                                                @break
                                          @case(2)
                                                Clásico.
                                                @break
                                          @case(3)
                                                Privanza.
                                                @break
                                          @default
                                    @endswitch
                                    </p>
                              </div>
                              @endif
                              <div class="col-md-3">
                                    <label class="text-primary">Largo de Manga Derecha</label>
                                    <p>{{ $orden->coat->largo_manga_derecha_saco }} <small>pulgadas</small></p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Largo de Manga Izquierda</label>
                                    <p>{{ $orden->coat->largo_manga_izquierda_saco }} <small>pulgadas</small></p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Largo de Espalda</label>
                                    <p>{{ $orden->coat->largo_espalda_deseado }} <small>pulgadas</small></p>
                              </div>
                        </div>
                        <h4>Saco Externo</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Solapa</label>
                                    
                                    @switch($orden->coat->tipo_solapa)
                                          @case(0)
                                                <p>Solapa en pico normal</p>
                                                @break
                                          @case(1)
                                                <p>Solapa en pico ancha</p>
                                                @break
                                          @case(2)
                                                <p>Solapa en escuadra normal</p>
                                                @break
                                          @case(3)
                                                <p>Solapa en escuadra ancha</p>
                                                @break
                                    @endswitch
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Ojal en Solapa</label>
                                     @switch($orden->coat->tipo_ojal_solapa)
                                          @case(0)
                                                <p>Sin ojal en solapa</p>
                                                @break
                                          @case(1)
                                                <p>Al tono</p>
                                                @break
                                          @case(2)
                                                <p>En contraste</p>
                                                @break
                                          
                                    @endswitch
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color en Ojal Solapa</label>
                                    
                                    <p>{{ $orden->coat->tipo_ojal_solapa ? 'Al tono' :  $orden->coat->color_ojal_solapa }}</p>


                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Número de botones de Frente</label>
                                    <p>{{ $orden->coat->botones_frente }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Ojal Activo en Solapa</label>
                                    <p>{{ $orden->coat->ojal_activo_solapa ? 'Ojal Activo.' : 'Ojal Inactivo' }}</p>
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
                                    @if ($orden->coat->tipo_ojal_manga === 0)
                                          <p>Al tono</p>.
                                          @switch($orden->coat->posicion_ojales_contraste)
                                                @case(0)
                                                      Ojal 1
                                                      @break
                                                @case(1)
                                                      Ojal 4
                                                      @break
                                                @case(2)
                                                      Todos los ojales
                                                      @break
                                                @default
                                          @endswitch
                                    @else
                                          <p>En contraste</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Ojal en Manga</label>
                                    @if ( $orden->coat->tipo_ojal_manga === 0)
                                          <p>Al tono</p>
                                    @else
                                          <p>{{ $orden->coat->color_ojal_manga }}</p>
                                    @endif
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Posición Ojal en Manga</label>
                                    @if ($orden->coat->posicion_ojal_manga === 0 )
                                          <p>Botones en cascada</p>
                                    @else
                                          <p>Botones en línea</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Ojales Activos en Manga</label>
                                    <p>{{ $orden->coat->ojales_activos_manga ? 'Si' : 'No' }}</p>
                              </div>
                              @if ($orden->coat->ojales_activos_manga)
                                    <div class="col-md-3">
                                          <label class="text-primary">Posición de los Ojales Activos en Manga</label>
                                          <p>
                                                @switch($orden->coat->posicion_ojales_activos_manga)
                                                      @case(0)
                                                            Cuarto
                                                            @break
                                                      @case(1)
                                                            Tercero y cuarto
                                                            @break
                                                      @case(2)
                                                            Segundo, tercero y cuarto
                                                            @break
                                                      @default
                                                            Todos
                                                @endswitch
                                          </p>
                                    </div>
                              @endif
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Bolsas Exteriores</label>
                                    @switch($orden->coat->tipo_bolsas_ext)
                                          @case(0)
                                                <p>Parche</p>
                                                @break
                                          @case(1)
                                                <p>Cartera</p>
                                                @break
                                          @case(2)
                                                <p>Cartera diagonal</p>
                                                @break
                                          @case(3)
                                                <p>Vivo (sin cartera)</p>
                                                @break
                                          @case(4)
                                                <p>Vivo diagonal</p>
                                                @break
                                          @case(5)
                                                <p>Cartera continental</p>
                                                @break
                                          @case(6)
                                                <p>Cartera continental diagonal</p>
                                                @break
                                          
                                    @endswitch
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">PickStitch</label>
                                    <p>{{ $orden->coat->pickstitch ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Aletilla</label>
                                    <p>{{ $orden->coat->sin_aletilla ? 'Sin Aletilla' : 'Aletilla normal' }}</p>
                              </div>
                              <div class="col-md-6">
                                    <label class="text-primary">Notas de Saco Externo</label>
                                    <p>{{ $orden->coat->notas_ext }}</p>
                              </div>
                        </div>
                        <h4>Saco Interno</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Vista</label>
                                    @if ( $orden->coat->tipo_vista === 0)
                                          <p>Normal</p>
                                    @else
                                          <p>Chapeta Francesa</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Forro Interno Mangas</label>
                                    <p>
                                          Balsam a rayas
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
                                    <label class="text-primary">Color de Puntada al tono</label>
                                    <p>{{ $orden->coat->color_puntada ? 'Sí' : 'No' }}</p>
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Bolsas Internas</label>
                                    @switch($orden->coat->bolsas_int)
                                          @case(0)
                                                <p>2 bolsas de pecho, 1 bolsa para pluma, 1 bolsa cigarrera</p>
                                                @break
                                          @case(1)
                                                <p>2 bolsas de pecho, 1 bolsa para pluma</p>
                                                @break
                                          @case(2)
                                                <p>2 bolsas de pecho, 1 bolsa cigarrera</p>
                                                @break
                                          @case(3)
                                                <p>2 bolsas de pecho</p>
                                                @break
                                    @endswitch
                              </div>
                              
                        </div>
                        <div class="row">
                              <div class="col-md-6">
                                    <label class="text-primary">Notas de Saco Interno</label>
                                    <p>{{ $orden->coat->notas_int }}</p>
                              </div>
                        </div>
                  @endif
                  {{-- Vest Data --}}
                  @if ($orden->has_vest)
                        <h3>Chaleco</h3>
                        <h4>Medidas de Cliente</h4>
                        <div class="row">
                              @if($orden->vest->fit->description)
                              <div class="col-md-3">
                                    <label class="text-primary">Fit</label>
                                    <p>{{ $orden->vest->fit->name }} <br><small>{{ $orden->vest->fit->description }}</small></p>
                              </div>
                              @endif
                              <div class="col-md-3">
                                    <label class="text-primary">Largo Espalda</label>
                                    <p>{{ $orden->vest->largo_espalda }}</p>
                              </div>
                        </div>
                        <h4>Especificaciones del Chaleco</h4>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Cuello</label>
                                    @if ( $orden->vest->tipo_cuello === 0)
                                          <p>En "V"</p>
                                    @else
                                          <p>Con solapa</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Bolsas</label>
                                    @if ( $orden->vest->tipo_bolsas === 0)
                                          <p>Vivos</p>
                                    @else
                                          <p>Aletillas</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Espalda</label>
                                    @if ( $orden->vest->tipo_espalda === 0)
                                          <p>Forro</p>
                                    @else
                                          <p>Tela</p>
                                    @endif
                              </div>
                              @if ($orden->vest->tipo_espalda == 1)
                                   <div class="col-md-3">
                                          <label class="text-primary">Tipo de Forro para Espalda</label>
                                          <p>{{ $orden->vest->tipo_forro }}</p>
                                    </div> 
                              @endif
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Ajustador en la Espalda</label>
                                    <p>{{ $orden->vest->ajustador_espalda ? 'Si' : 'No' }}</p>
                              </div>
                              <div class="col-md-6">
                                    <label class="text-primary">Notas de Chaleco</label>
                                    <p>{{ $orden->vest->notas }}</p>
                              </div>
                        </div>
                  @endif

                  @if ($orden->has_pants)
                        <h3>Pantalón</h3>
                        <h4>Medidas de Cliente</h4>
                        <div class="row">
                              @if($orden->pants->fit->description)
                              <div class="col-md-3">
                                    <label class="text-primary">Fit</label>
                                    <p>{{ $orden->pants->fit->name }} <br><small>{{ $orden->pants->fit->description}}</small></p>
                              </div>
                              @endif
                              <div class="col-md-3">
                                    <label class="text-primary">Talla</label>
                                    <p>{{ $orden->pants->talla }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Largo Exterior Terminado</label>
                                    <p>{{ $orden->pants->largo_ext }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Largo Interior Terminado</label>
                                    <p>{{ $orden->pants->largo_int }}</p>
                              </div>
                        </div>
                        <h4>Especificaciones del Pedido</h4>
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
                                    @if ( $orden->pants->tipo_vivo === 0)
                                          <p>Vivo doble con ojal</p>
                                    @else
                                          <p>Vivo sencillo con ojal</p>
                                    @endif
                              </div>
                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Ojalera</label>
                                    <p>{{ $orden->pants->color_ojalera }}</p>
                              </div>
                              
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Dobladillo</label>
                                    @if ( $orden->pants->dobladillo === 0)
                                          <p>Dobladillo normal</p>
                                    @else
                                          <p>Valenciana Española</p>
                                    @endif
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Tipo de Pretina</label>
                                    @switch($orden->pants->pretina)
                                          @case(0)
                                                <p>Flexon</p>
                                                @break
                                          @case(1)
                                                <p>Snutex</p>
                                                @break
                                          @case(2)
                                                <p>Bies</p>
                                                @break                                          
                                    @endswitch
                              </div>

                        </div>
                        <div class="row">
                              <div class="col-md-3">
                                    <label class="text-primary">Color de Pretina</label>
                                    <p>{{ $orden->pants->color_pretina }}</p>
                              </div>
                              <div class="col-md-3">
                                    <label class="text-primary">Notas de Pantalón</label>
                                    <p>{{ $orden->pants->notas }}</p>
                              </div>
                        </div>
                  @endif
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ url('/admin/ordenes') }}" class="btn btn-info">Regresar</a>
            <a href="{{ url('/admin/ordenes/'.$orden->id.'/pdf') }}" class="btn btn-warning">Exportar a PDF</a>
	</div>
</div>
@endsection