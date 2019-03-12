@extends('admin.layout.main')

@section('content')
{{-- CSS --}}
<link href="{{ asset('wizard/css/material-bootstrap-wizard.css') }}" rel="stylesheet"/>
{{-- Javascript --}}
<script src="{{ asset('wizard/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('wizard/js/jquery.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('wizard/js/material-bootstrap-wizard.js') }}"></script>
<script src="{{ asset('wizard/js/jquery.validate.min.js') }}"></script>

<style>
	/*
	Estilos para ajustar discrepancias entre Material Dashboard y Material Wizard
	*/
	.wizard-container {
		padding: 0px !important;
		z-index: auto !important;
	}
	.wizard-navigation a {
		box-shadow: none !important;
		-webkit-box-shadow: none !important;
	}
	.btn{
      	white-space:normal !important;
      	max-width:500px;
  	}
</style>
<div>
	@if ($errors->any())
	    <div class="alert alert-danger">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif
</div>
<div class="row">
    <div class="col-sm-12">
        <!--      Wizard container        -->
        <div class="wizard-container">
            <div class="card wizard-card" data-color="blue" id="wizard">
                <form action="{{ url('/admin/ordenes') }}/@yield('editOrden')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');">
                	{{ csrf_field() }}
                	@section('editMethod')
                    	@show
                	<div class="wizard-header">
                    	<h3 class="wizard-title">
                    		Añadir Orden
                    	</h3>
						<h5>Formulario para registrar/editar un pedido</h5>
                	</div>
					<div class="wizard-navigation">
						<ul>
							<li><a href="#inicio" data-toggle="tab">Datos Iniciales</a></li>
                            <li><a href="#saco" data-toggle="tab">Saco</a></li>
                            <li><a href="#chaleco" data-toggle="tab">Chaleco</a></li>
                            <li><a href="#pantalon" data-toggle="tab">Pantalón</a></li>
                            <li><a href="#finalizar" data-toggle="tab">Finalizar</a></li>
                        </ul>
					</div>
                    <div class="tab-content">
						{{-- Primer Pestaña --}}
						<div class="tab-pane" id="inicio">
							<h4 class="info-text">Comencemos con los datos básicos.</h4>
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									<div class="col-md-6">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="material-icons">person</i>
											</span>
											<div class="form-group label-floating">
				                                <label class="control-label">Cliente</label>
				                                <select class="form-control" name="cliente">
				                                    <option disabled="" 
				                                    @hasSection('editCliente')
				                                    {{-- Ya hay un cliente seleccionado --}}
				                                    @else
				                                      selected="" 
				                                    @endif></option>
				                                    @foreach ($clientes as $cliente)
				                                        <option value="{{ $cliente->id }}"
				                                          @hasSection('editCliente')
				                                            @if ($orden->client->id == $cliente->id)
				                                              selected="" 
				                                            @endif
				                                          @endif>
				                                            {{ $cliente->name.' '.$cliente->lastname.' ('.$cliente->email.')' }}
				                                        </option>
				                                    @endforeach
				                                </select>
				                            </div>
										</div>
									</div>
									<div class="col-md-6">
										<a href="{{ url('/validador/clientes/agregar') }}" class="btn btn-warning">
											Si el cliente no se encuentra registrado, haz click aquí
										</a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5 class="text-center">Selecciona las piezas a trabajar:</h5>
								</div>
								<div class="col-md-4 text-center">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="saco" id="checkSaco" 
											@hasSection('editCoat')
												@if ($orden->has_coat)
												 	checked="1"
												 @endif 
											@endif
											>
										</label>
										Saco
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="chaleco" id="checkChaleco"
											@hasSection('editVest')
												@if ($orden->has_vest)
													checked="1"
												@endif
											@endif
											>
										</label>
										Chaleco
									</div>
								</div>
								<div class="col-md-4 text-center">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="pantalon" id="checkPantalon"
											@hasSection('editPants')
												@if ($orden->has_pants)
													checked="1" 
												@endif
											@endif
											>
										</label>
										Pantalón
									</div>
								</div>
							</div>
							
							{{-- Datos generales --}}
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<h4 class="text-center">¿Qué tipo de tela se usará?</h4>
                                    <div class="col-xs-6">
                                        <div class="choice" id="telaCliente" data-toggle="wizard-radio" rel="tooltip" title="Selecciona esta opción si la tela la proporcionará el cliente.">
                                            <input type="radio" name="tipoTela" value="cliente">
                                            <div class="icon">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </div>
                                            <h6>Cliente</h6>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="choice" id="telaIsco" data-toggle="wizard-radio" rel="tooltip" title="Selecciona esta opción si la tela es propiedad de ISCO.">
                                            <input type="radio" name="tipoTela" value="isco"
											@hasSection('tipoTelaIsco')
												@if ($orden->tela_isco)
													checked="1" 
												@endif
											@endif
                                            >
                                            <div class="icon">
                                                <i class="fa fa-industry" aria-hidden="true"></i>
                                            </div>
                                            <h6>ISCO/Privanza</h6>
                                        </div>
                                    </div>
                                    <div id="telaClienteDatos" style="display: none;" class="col-xs-8 col-xs-offset-2">
                                    	<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Código de Tela del Cliente:</label>
	                                          	<input name="codigoTelaCliente" type="text" class="form-control" value="@yield('editCodigoTela')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre de la tela:</label>
	                                          	<input name="nombreTelaCliente" type="text" class="form-control" value="@yield('editNombreTela')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Tela:</label>
	                                          	<input name="codigoColorTelaCliente" type="text" class="form-control" value="@yield('editCodigoColorTela')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Color de Tela:</label>
	                                          	<input name="colorTelaCliente" type="text" class="form-control" value="@yield('editColorTela')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-arrows-h" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Metros entregados:</label>
	                                          	<input name="mtsTelaCliente" type="number" step="0.1" class="form-control" min="0" value="@yield('editMetrosTela')">
	                                        </div>
	                                    </div>
                                    </div>
                                    <div id="telaIscoDatos" style="display: none;" class="col-xs-8 col-xs-offset-2">
                                    	<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Código de Tela ISCO:</label>
	                                          	<input name="codigoTelaIsco" type="text" class="form-control" value="@yield('editCodigoTelaIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre de la tela:</label>
	                                          	<input name="nombreTelaIsco" type="text" class="form-control" value="@yield('editNombreTelaIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Tela:</label>
	                                          	<input name="codigoColorTelaIsco" type="text" class="form-control" value="@yield('editCodigoColorTelaIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Color de Tela:</label>
	                                          	<input name="colorTelaIsco" type="text" class="form-control" value="@yield('editColorTelaIsco')">
	                                        </div>
	                                    </div>
                                    </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<h4 class="text-center">¿Qué tipo de forro se usará?</h4>
                                    <div class="col-xs-6">
                                        <div class="choice" id="forroCliente" data-toggle="wizard-radio" rel="tooltip" title="Selecciona esta opción si el forro lo proporcionará el cliente.">
                                            <input type="radio" name="tipoForro" value="cliente">
                                            <div class="icon">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                            </div>
                                            <h6>Cliente</h6>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="choice" id="forroIsco" data-toggle="wizard-radio" rel="tooltip" title="Selecciona esta opción si el forro es propiedad de ISCO.">
                                            <input type="radio" name="tipoForro" value="isco">
                                            <div class="icon">
                                                <i class="fa fa-industry" aria-hidden="true"></i>
                                            </div>
                                            <h6>ISCO/Privanza</h6>
                                        </div>
                                    </div>
                                    <div id="forroClienteDatos" style="display: none;" class="col-xs-8 col-xs-offset-2">
                                    	<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Código de Forro del Cliente:</label>
	                                          	<input name="codigoForroCliente" type="text" class="form-control" value="@yield('editCodigoForro')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre del Forro:</label>
	                                          	<input name="nombreForroCliente" type="text" class="form-control" value="@yield('editNombreForro')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Forro:</label>
	                                          	<input name="codigoColorForroCliente" type="text" class="form-control" value="@yield('editCodigoColorForro')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Color del Forro:</label>
	                                          	<input name="colorForroCliente" type="text" class="form-control" value="@yield('editColorForro')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-arrows-h" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Metros entregados:</label>
	                                          	<input name="mtsForroCliente" type="number" step="0.1" class="form-control" value="@yield('editMetrosForro')">
	                                        </div>
	                                    </div>
                                    </div>
                                    <div id="forroIscoDatos" style="display: none;" class="col-xs-8 col-xs-offset-2">
                                    	<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Código de Forro ISCO:</label>
	                                          	<input name="codigoForroIsco" type="text" class="form-control" value="@yield('editCodigoForroIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre del Forro:</label>
	                                          	<input name="nombreForroIsco" type="text" class="form-control" value="@yield('editNombreForroIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Forro:</label>
	                                          	<input name="codigoColorForroIsco" type="text" class="form-control" value="@yield('editCodigoColorForroIsco')">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Color del Forro:</label>
	                                          	<input name="colorForroIsco" type="text" class="form-control" value="@yield('editColorForroIsco')">
	                                        </div>
	                                    </div>
                                    </div>
								</div>
							</div>

							<div class="row">
								
								<div class="col-md-8 col-md-offset-2">
									<h4 class="text-center">Datos de Botones</h4>
									<div class="checkbox text-center">
										<label>
											<input type="checkbox" name="botonesCliente" id="botonesCliente"
											@hasSection('editTipoBotones')
												@if ($orden->tipo_botones)
												 	checked="1"
												 @endif 
											@endif
											>
										</label>
										Botones de cliente
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Código de Botones</label>
											<input type="text" name="codigoBotones" class="form-control" value="@yield('editCodigoBotones')">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Color de Botones</label>
											<input type="text" class="form-control" name="colorBotones" value="@yield('editColorBotones')">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating" id="cantidadBotones">
											<label for="" class="control-label">Cantidad de botones</label>
											<input type="number" class="form-control" name="cantidadBotones" value="@yield('editCantidadBotones')">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<h4 class="text-center">Etiquetas</h4>
									<p class="text-center">(No seleccionar ninguno para Privanza)</p>
									<div class="col-md-10 col-md-offset-1">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaTela" id="checkEtiquetaTela"
												@hasSection('editEtiquetaTela')
													@if ($orden->etiquetas_tela)
														checked="1" 
													@endif
												@endif
												>
											</label>
											Se Reciben Etiquetas de Tela
										</div>
										<div class="form-group label-floating" id="marcaTela">
											<label class="control-label"><small>Ingrese la marca:</small></label>
											<input type="text" class="form-control" name="marcaTela" value="@yield('editMarcaTela')">
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaMarca" id="checkEtiquetaMarca"      @hasSection('editEtiquetaMarca')
													@if ($orden->etiquetas_marca)
														checked="1" 
													@endif
												@endif>
											</label>
											Se Reciben Etiquetas de Marca
										</div>										
										<div class="form-group label-floating" id="marcaEtiqueta">
											<label class="control-label"><small>Ingrese la marca:</small></label>
											<input type="text" class="form-control" name="marcaEtiqueta" value="@yield('editMarcaEtiqueta')">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Gancho</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de gancho...</label>
		                                <select class="form-control" id="tipoGancho" name="tipoGancho">
		                                    	<option disabled="" selected="" ></option>
		                                        <option value="0" {{(isset($orden->gancho) && $orden->gancho === 0) ? 'selected' : ''}}>Normal</option>
		                                        <option value="1" {{(isset($orden->gancho) && $orden->gancho === 1) ? 'selected' : ''}}>Personalizado Privanza</option>
		                                        <option value="2" {{(isset($orden->gancho) && $orden->gancho === 2) ? 'selected' : ''}}>Otro</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating" id="personalizacionGancho">
		                            	<label class="control-label">Personalización Gancho: <small>(opcional)</small></label>
		                            	<input type="text" name="perGancho" class="form-control" value="@yield('editPerGancho')">
		                            </div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Portatrajes</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de portatrajes...</label>
		                                <select class="form-control" id="tipoPortatrajes" name="tipoPortatrajes">
		                                    <option disabled="" selected=""></option>
		                                    <option value="0" {{(isset($orden->portatrajes) && $orden->portatrajes === 0) ? 'selected' : ''}} >Cubrepolvos</option>
		                                    <option value="1" {{(isset($orden->portatrajes) && $orden->portatrajes === 1) ? 'selected' : ''}}>Personalizado Privanza</option>
		                                    <option value="2" {{(isset($orden->portatrajes) && $orden->portatrajes === 2) ? 'selected' : ''}}>Otro</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating" id="personalizacionPortatrajes">
		                            	<label class="control-label">Personalización Portatrajes: <small>(opcional)</small></label>
		                            	<input type="text" name="perPortatrajes" class="form-control" value="@yield('editPerPortatrajes')">
		                            </div>
								</div>								
							</div>
							{{-- Bordado de iniciales--}}
							<div class="row">
								<h4 class="text-center">Bordado de iniciales (opcional)</h4>
								<div class="col-md-4 col-md-offset-4">											
									<div class="form-group label-floating">
										<label class="control-label">Nombre:</label>
		                            	<input type="text" name="bordadoNombre" class="form-control" value="@yield('editNombreBordado')">
		                            </div>
									<div class="row text-center">
										<div class="col-xs-3 col-xs-offset-3">
											<label>
			  									<input type="radio" name="letra" value="Molde" id="letraMolde" />
			  									<img src="{{ asset('img/suit_options/letras/bordado_molde.png') }}">
			  									<p>Letra de molde</p>
											</label>									
										</div>
										<div class="col-xs-3">
											<label>
			  									<input type="radio" name="letra" value="Cursiva" id="letraCursiva" />
			  									<img src="{{ asset('img/suit_options/letras/bordado_cursiva.png') }}">
			  									<p>Letra cursiva</p>
											</label>
										</div>										
									</div>									
										<p>El color por defecto para el bordado es gris plata, si desea un color distinto, colóquelo abajo</p>									
									<div class="form-group label-floating">
										<label class="control-label">Otro Color <small>(opcional)</small>:</label>
		                            	<input type="text" name="bordadoColor" class="form-control" value="@yield('editColorBordado')">
		                            </div>	
		                            <div class="row">
										<center><h4>Notas del Bordado</h4></center>
										<div class="form-group label-floating">
		                                	<label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                	<textarea name="notasBordado"  rows="2" class="form-control">@if(isset($orden->notasBordado)){{ ucfirst($orden->notasBordado) }} @endif</textarea>
		                            	</div>
									</div>
								</div>
								<div class="row">
	                    			<div class="col-md-3 col-md-offset-3">
	                        			<div class="form-group label-floating">
	                            			<label class="control-label">Precio</label>
	                            			<input name="precio" type="number" class="form-control" value="@yield('editPrecio')">
	                        			</div>
	                    			</div>
	                    			<div class="col-md-3">
	                        			<div class="form-group label-floating">
	                            			<label class="control-label">Consecutivo de operación</label>
	                            			<input type="text" name="consecutivo_op" class="form-control" value="@yield('editCOP')">
	                        			</div>
	                    			</div>
	                			</div>								
							</div>
						</div>
						{{-- Tab Saco --}}
						<div class="tab-pane" id="saco">
							<h4 class="info-text">Datos de la parte Externa del Saco</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p>Observaciones generales del cliente:</p>
									<div class="row">
										<div class="col-md-4 ">									
											<div class="form-group label-floating">
												<label class="control-label">Fit deseado</label>
												<select name="fitSaco" id="tipoHolguraSaco" class="form-control">
													<option disabled="" selected="" ></option>				
													<option value="2" {{(isset($orden->coat) && $saco->fit_id === 2) ? 'selected' : ''}}>Clásico (4" 3")</option>
													<option value="3" {{(isset($orden->coat) && $saco->fit_id === 3) ? 'selected' : ''}}>Privanza (3" 2")</option>
													<option value="1" {{(isset($orden->coat) && $saco->fit_id === 1) ? 'selected' : ''}}>Especial</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Largo de manga derecha<small> (pulgadas)</small>:</label>
												<input type="number" min="10" step=".1" name="largoMangaDerechaSaco" id="talla" class="form-control" value="@yield('editLargoMangaDerecha')">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Largo de espalda deseado<small> (pulgadas)</small>:</label>
												<input type="number" min="10" step=".1" name="largoEspaldaSaco" id="largoEspaldaSaco" class="form-control" value="@yield('editLargoEspalda')">
											</div>
										</div>																			
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group label-floating" id="personalizacionHolguraSaco">
	                            				<label class="control-label">Ingrese las pulgadas de holgura: </label>
	                            				<input type="text" name="personalizacionHolguraSaco" class="form-control" value="@yield('editPerSaco')">
											</div>
	                            		</div>
	                            		<div class="col-md-4">
	                            			<div class="form-group label-floating">
												<label class="control-label">Largo de manga izquierda<small> (pulgadas)</small>:</label>
												<input type="number" min="10" step=".1" name="largoMangaDerechaSaco" id="talla" class="form-control" value="@yield('editLargoMangaIzquierda')">
											</div>
	                            		</div>
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el tipo de solapa:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="0" id="solapaNormal" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_picodelgado.png') }}">
										  <p class="text-center">Solapa en Pico <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="1" id="solapaAncha"/>
										  <img src="{{ asset('img/suit_options/saco/Cuello_PicoAncho.png') }}">
										  <p class="text-center">Solapa en Pico <b>Ancha</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="2" id="solapaEscuadraNormal"/>
										  <img src="{{ asset('img/suit_options/saco/Cuello_Delgado.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="3" id="solapaEscuadraAncha"/>
										  <img src="{{ asset('img/suit_options/saco/Cuello_Ancho.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Ancha</b></p>
										</label>
									</div>
								</div>
								<div class="col-md-10 col-md-offset-1">
									<h4 class="text-center">Ojales</h4>
									<div class="row">
										<div class="col-sm-4 col-sm-offset-1">
											<h5 class="text-center">Mangas</h5>
											<div class="form-group label-floating">
												<label class="control-label">Color de ojal en Manga</label>
												<select name="tipoOjalManga" class="form-control" id="tipoDeOjalEnManga">
													<option disabled=""></option>
													<option value="0" {{(isset($saco->tipo_ojal_manga) && $saco->tipo_ojal_manga === 0) ? 'selected' : ''}}>Al tono</option>
													<option value="1" {{(isset($saco->tipo_ojal_manga) && $saco->tipo_ojal_manga === 1) ? 'selected' : ''}}>En contraste</option>
												</select>
											</div>
											<div class="form-group label-floating" id="divPosicionOjalesManga">
		                                		<label class="control-label">Posición de Ojales en contraste para manga</label>
		                                		<select class="form-control" name="posicionOjalesContrasteMangas">
				                                    <option disabled="" selected=""></option>
				                                    <option value="0" {{(isset($saco->posicion_ojales_contraste) && $saco->posicion_ojales_contraste === 0) ? 'selected' : ''}}> 1</option>
				                                    <option value="1" {{(isset($saco->posicion_ojales_contraste) && $saco->posicion_ojales_contraste === 1) ? 'selected' : ''}}> 4</option>
				                                    <option value="2" {{(isset($saco->posicion_ojales_contraste) && $saco->posicion_ojales_contraste === 2) ? 'selected' : ''}}> Todos</option>
				                                </select>	                                		
		                            		</div>		
											<div class="checkbox">
												<label>
													<input type="checkbox" name="ojalesActivosManga" id="ojalesActivosManga" >
													Selecciona para que el ojal sea activo
												</label>
											</div>
											<div class="form-group label-floating" id="divOjalesActivosManga">
			                                	<label class="control-label">Posición de Ojales Activos</label>
			                                	<select class="form-control" name="posicionOjalesActivosManga">
				                                    <option disabled="" selected=""></option>
				                                    <option value="0" {{(isset($saco->posicion_ojales_activos_manga) && $saco->posicion_ojales_activos_manga === 0) ? 'selected' : ''}}> 4</option>
				                                    <option value="1" {{(isset($saco->posicion_ojales_activos_manga) && $saco->posicion_ojales_activos_manga === 1) ? 'selected' : ''}}> 2, 3, 4 </option>
				                                    <option value="2" {{(isset($saco->posicion_ojales_activos_manga) && $saco->posicion_ojales_activos_manga === 2) ? 'selected' : ''}}> Todos</option>
				                                     <option value="3" {{(isset($saco->posicion_ojales_activos_manga) && $saco->posicion_ojales_activos_manga === 3) ? 'selected' : ''}}> 3 y 4</option>
				                                </select>	                                		
			                            	</div>			                            	
										</div>		
								
										<div class="col-sm-4 col-sm-offset-1">
											<h5 class="text-center">Solapa</h5>
											<div class="form-group label-floating">
												<label class="control-label">Color de ojal en Solapa</label>
												<select name="tipoOjalSolapa" class="form-control" id="ojalEnSolapa">
													<option disabled="" selected=""></option>
													<option value="0" {{(isset($saco->tipo_ojal_solapa) && $saco->tipo_ojal_solapa === 0) ? 'selected' : ''}}>Al tono</option>
													<option value="1" {{(isset($saco->tipo_ojal_solapa) && $saco->tipo_ojal_solapa === 1) ? 'selected' : ''}}>En contraste</option>
												</select>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="ojalActivoSolapa" id="ojalActivoSolapa">
													Selecciona para que el ojal sea activo
												</label>
											</div>
										</div>					
									</div>
									
								</div>					
							</div>
							<div class="col-md-10 col-sm-offset-1">
								<div class="col-md-6">
									<img src="{{ asset('img/suit_options/saco/manga_normal.jpg') }}" alt="Imágen de Indicador de Botones">
								</div>		
								<div class="col-sm-6" id="solapaContraste">
									<p>Selecciona el color de los ojales en contraste:</p>
									@include('partials.color-palette', ['varName' => 'OjalSolapa'])
											
								</div>									
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el número de botones:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="1" id="unBoton" />
										  <img src="{{ asset('img/suit_options/saco/Saco_1boton.png') }}">
										  <p class="text-center">1 Botón</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="2" id="dosBotones" />
										  <img src="{{ asset('img/suit_options/saco/Saco_2botones.png') }}">
										  <p class="text-center">2 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="3" id="tresBotones" />
										  <img src="{{ asset('img/suit_options/saco/Saco_3botones.png') }}">
										  <p class="text-center">3 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="6" id="seisBotones" />
										  <img src="{{ asset('img/suit_options/saco/Saco_6botones.png') }}">
										  <p class="text-center">6 botones</p>
										</label>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el número de aberturas detrás:</p>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="0" id="sinAberturas" />
										  <img src="{{ asset('img/suit_options/saco/Espalda_SinAberturas.png') }}">
										  <p class="text-center">Sin Aberturas</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="1" id="unaAbertura"/>
										  <img src="{{ asset('img/suit_options/saco/Espalda_UnaAbertura.png') }}">
										  <p class="text-center">1 Abertura</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="2" id="dosAberturas"/>
										  <img src="{{ asset('img/suit_options/saco/Espalda_DosAberturas.png') }}">
										  <p class="text-center">2 Aberturas</p>
										</label>
									</div>
								</div>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Mangas</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<div class="form-group label-floating">
											<label class="control-label">Botones en Mangas:</label>
											<select name="botonesMangas" id="botonesMangas" class="form-control" ue">
												<option disabled="" selected=""></option>
												<option value="1" {{(isset($saco->botones_mangas) && $saco->botones_mangas === 1) ? 'selected' : ''}}>1 Botón</option>
												<option value="2" {{(isset($saco->botones_mangas) && $saco->botones_mangas === 2) ? 'selected' : ''}}>2 Botones</option>
												<option value="3" {{(isset($saco->botones_mangas) && $saco->botones_mangas === 3) ? 'selected' : ''}}>3 Botones</option>
												<option value="4" {{(isset($saco->botones_mangas) && $saco->botones_mangas === 4) ? 'selected' : ''}}>4 Botones</option>
											</select>
										</div>
									</div>
									
								</div>
								
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<p class="col-md-12">Selecciona la posición de los ojales:</p>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="0" id="botonesCascada"/>
											  <img src="{{ asset('img/suit_options/saco/Manga_Cascada.png') }}">
											  <p class="text-center">Botones en Cascada</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="1" id="botonesLinea" />
											  <img src="{{ asset('img/suit_options/saco/Manga_Normal.png') }}">
											  <p class="text-center">Botones en Línea</p>
											</label>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Bolsas Externas</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="0" id="parche" />
										  <img src="{{ asset('img/suit_options/saco/Parches.png') }}">
										  <p class="text-center">Parche</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="1" id="cartera" />
										  <img src="{{ asset('img/suit_options/saco/Cartera.png') }}">
										  <p class="text-center">Cartera</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="2" id="CarteraDiagonal" />
										  <img src="{{ asset('img/suit_options/saco/CarteraDiagonal.png') }}">
										  <p class="text-center">Cartera en Diagonal</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="3" id="vivo" />
										  <img src="{{ asset('img/suit_options/saco/Vivos.png') }}">
										  <p class="text-center">Vivo (sin cartera)</p>
										</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="4" id="vivoDiagonal" />
										  <img src="{{ asset('img/suit_options/saco/VivosDiagonal.png') }}">
										  <p class="text-center">Vivo Diagonal</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="5" id="continental" />
										  <img src="{{ asset('img/suit_options/saco/CarteraContinental.png') }}">
										  <p class="text-center">Cartera Continental <small>Sólo lado derecho</small></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="6" id="continentalDiagonal" />
										  <img src="{{ asset('img/suit_options/saco/CarteraContinentalDiagonal.png') }}">
										  <p class="text-center">Cartera Continental Diagonal <small>Sólo lado derecho</small></p>
										</label>
									</div>									
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Otros</h4>
									</div>
									<div class="col-md-6 text-center">
										<label>
										  <input type="checkbox" name="pickstitch" id="checkPickstitch" />
										  <img src="{{ asset('img/suit_options/saco/pick-stitch.png') }}"  id="pickstitch">
										  <p class="text-center">Seleccione si desea PickStitch</p>
										</label>
									</div>
									<div class="col-md-6">
										<p>
											Opciones de Aletilla
											<small>(Por defecto lo confeccionamos con aletilla normal)</small>
										</p>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="sinaletilla" id="sinAletilla">
												Sin Aletilla
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<h4>Notas del Saco Externo</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasSacoExt" id="notasSacoExt" rows="5" class="form-control"> @if(isset($saco->notas_ext)){{ ucfirst($saco->notas_ext) }} @endif</textarea>
		                            </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1 text-center">
									<h4 class="info-text">Datos de la parte Interna del Saco</h4>
									<p class="text-center">Tipo de Vista:</p>
									<div class="col-md-6 col-xs-6">
										<label>
										  <input type="radio" name="tipoVista" value="0" id="vistaNormal" />
										  <img src="{{ asset('img/suit_options/saco/Chapeta_Normal.png') }}">
										  <p class="text-center">Normal</p>
										  <p class="text-center">Los vivos de las bolsas internas van al tono de pinpoint y/o bies</p>
										</label>
									</div>
									<div class="col-md-6 col-xs-6">
										<label>
										  <input type="radio" name="tipoVista" value="1" id="chapetaFrancesa" />
										  <img src="{{ asset('img/suit_options/saco/Chapeta_Francesa.png') }}">
										  <p class="text-center">Chapeta Francesa</p>
										  <p class="text-center">Los vivos de las bolsas internas van del mismo tono del cuerpo</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<h4 class="text-center">Forro Interno en Mangas</h4>
								<div class="col-md-6 col-md-offset-3 text-center">
										<strong>
											Balsam a Rayas
										</strong>
								</div>
							</div>
							<div class="row">
								<h4 class="text-center">Accesorios</h4>
							</div>
							<!--Bies & PinPoint-->
							<div class="row">
								<div class="col-md-4">
									<label>
									  <input type="radio" name="tipoAccesorio" id="tipoAccesorio1" value="0"/>
									  <img src="{{ asset('img/suit_options/saco/pin-point.png') }}">
									  <p class="text-center">PinPoint</p>
									</label>
									<div class="label-floating form-group">
										<label class="control-label">Código de Pin Point <small>(opcional)</small></label>
										<input type="text" class="form-control" name="pinPointInternoCodigo">
									</div>
								</div>
								<div class="col-md-4">
									<label>
									  <input type="radio" name="tipoAccesorio" value="1" id="tipoAccesorio2"/>
									  <img src="{{ asset('img/suit_options/saco/bies.jpg') }}">
									  <p class="text-center">Bies</p>
									</label>
									<div class="label-floating form-group">
										<label class="control-label">Código de Bies <small>(opcional)</small></label>
										<input type="text" class="form-control" name="biesInternoCodigo">
									</div>
								</div>
								<div class="col-md-4">
									<label>
										<input type="radio" name="tipoAccesorio" value="2" id="tipoAccesorio3"/>
										<img src="{{ asset('img/suit_options/saco/pinpointBies.png') }}">
										<p class="text-center">Pin Point y Bies</p>
									</label>
									<div class="label-floating form-group">
										<label class="control-label">Código <small>(opcional)</small></label>
										<input type="text" class="form-control" name="pinpointbiesInternoCodigo">
									</div>
								</div>
							</div>
							<!--Fin de Bies & PinPoint-->
							<!--Color de Bies & PinPoint-->
							
							<div class="row">		
								<div class="col-md-10 col-md-offset-1">							
									<div class="col-md-6 col-md-offset-3" id="colorPaletteBiesPinpoint">
										@include('partials.color-palette', ['varName' => 'Puntada'])
									</div>
								</div>					
							</div>
							<!--Fin de Color de Bies & PinPoint-->
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Bolsas Internas</h4>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-3 col-xs-6">
									<label> 
									  <input type="radio" name="bolsasInt" value="0" id="CheckOpcUnoBolsasInternas" />
									  <img src="{{ asset('img/suit_options/saco/4Bolsas.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa para pluma, 1 bolsa cigarrera</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-6">
									<label>
									  <input type="radio" name="bolsasInt" value="1" id="CheckOpcDosBolsasInternas" />
									  <img src="{{ asset('img/suit_options/saco/2Bolsas_Pecho_Plumera.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa para pluma</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-12">
									<label>
									  <input type="radio" name="bolsasInt" value="2" id="CheckOpcTresBolsasInternas" />
									  <img src="{{ asset('img/suit_options/saco/3Bolsas.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa cigarrera</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-12">
									<label>
									  <input type="radio" name="bolsasInt" value="3" id="CheckOpcCuatroBolsasInternas" />
									  <img src="{{ asset('img/suit_options/saco/2Bolsas_Pecho.png') }}">
									  <p class="text-center">2 bolsas de pecho</p>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Saco Interno</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasSacoInt" id="notasSacoInt" rows="5" class="form-control">@if(isset($saco->notas_int)){{ ucfirst($saco->notas_int) }} @endif</textarea>
		                            </div>
								</div>
							</div>						
						</div>
						{{-- Tab Chaleco--}}
						<div class="tab-pane" id="chaleco">
                    		<h3 class="info-text">Datos del Chaleco</h3>
                    		<div class="row">
                    			<div class="col-md-10 col-md-offset-1">
                    				<p>Observaciones generales del cliente:</p>
                    				<div class="row">
                    					<div class="col-md-6">
                    						<div class="form-group label-floating">
												<label class="control-label">Fit deseado</label>
												<select name="fitChaleco" id="fitChaleco" class="form-control">
													<option disabled="" selected="" ></option>
													<option value="1" {{(isset($chaleco) && $chaleco->fit_id === 1) ? 'selected' : ''}}>Especial <small></small></option>
													<option value="2" {{(isset($chaleco) && $chaleco->fit_id === 2) ? 'selected' : ''}}>Clásico</option>
													<option value="3" {{(isset($chaleco) && $chaleco->fit_id === 3) ? 'selected' : ''}}>Privanza</option>
												</select>
											</div>
                    					</div>
                    					<div class="col-md-6">
                    						<div class="form-group label-floating">
                    							<label class="control-label">Largo de espalda deseado <small>(pulgadas)</small>:</label>
                    							<input type="number" min="10" step=".1" name="tallaChaleco" id="tallaChaleco" class="form-control" value="@yield('editLargoEspaldaChaleco')">
                    						</div>
                    					</div>
                    				</div>
                    				
                    			</div>
                    		</div>
                    		<h5 class="info-text">Tipo de Cuello</h5>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
                    				<div class="row">
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="cuelloChaleco" value="0" id="enV" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_V.png') }}">
											  <p class="text-center">En 'V'</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="cuelloChaleco" value="1" id="conSolapa" />
											  <img src="{{ asset('img/suit_options/chaleco/chaleco_solapa.jpg') }}">
											  <p class="text-center">Con Solapa</p>
											</label>
										</div>
									</div>
								</div>
                    		</div>
                    		<h4 class="info-text">Bolsas Delanteras</h4>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
                    				<div class="row">
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="bolsasChaleco" value="0" id="vivos" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Vivos.png') }}">
											  <p class="text-center">Vivos</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="bolsasChaleco" value="1" id="aletilla" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Aletilla.png') }}">
											  <p class="text-center">Aletillas</p>
											</label>
										</div>
									</div>
								</div>
                    		</div>
                    		<h4 class="info-text">Espalda Forro o Tela con hebilla para ajuste</h4>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
                    				<div class="row">
                    					<div class="col-xs-6">
                    						<label>
                    							<input type="radio" name="forroTela" value="0" id="espaldaForro">
                    							<img src="{{ asset('img/suit_options/chaleco/Chaleco_espalda_forro.png') }}" alt="">
                    							<p class="text-center">Forro</p>
                    						</label>
                    					</div>
                    					<div class="col-xs-6">
                    						<label>
                    							<input type="radio" name="forroTela" value="1" id="espaldaTela">
                    							<img src="{{ asset('img/suit_options/chaleco/Chaleco_Espalda.png') }}" alt="">
                    							<p class="text-center">Tela</p>
                    						</label>
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    		<div class="row">
                    			<p class="text-center">Tipo de Forro</p>
                    			<div class="col-md-8 col-md-offset-2">
                    				<div class="checkbox text-center">
										<label>
											<input type="checkbox" name="tipoForroChaleco" id="tipoForroChaleco" value="Mismo Seleccionado en Saco">
											Mismo Seleccionado en Saco
										</label>
									</div>
									<div class="form-group label-floating" id="otroForroChaleco">
										<label class="control-label">Código de Otro Forro <small>(opcional)</small>:</label>
										<input type="text" class="form-control" name="codigoOtroForroChaleco" value="@yield('editForroChaleco')">
									</div>
                    			</div>
                    		</div>
                    		
                    		<div class="row">
                    			<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Chaleco</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasChaleco" id="notasChaleco" rows="5" class="form-control">@if(isset($chaleco->notas)){{ ucfirst($chaleco->notas) }} @endif</textarea>
		                            </div>
								</div>
							</div>
                    	</div>
                    	{{-- Fin Tab Chaleco --}}
						{{-- Tab Pantalón --}}
						<div class="tab-pane" id="pantalon">
							<h4 class="info-text">Datos del Pantalón</h4>
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<p>Observaciones generales del cliente:</p>
									<div class="row">
										<div class="col-md-12">
                    						<div class="form-group label-floating">
												<label class="control-label">Fit para Pantalón</label>
												<select name="fitPantalon" id="fitPantalon" class="form-control">
													<option disabled="" selected=""></option>
													<option value="1" {{(isset($pantalon) && $pantalon->fit_id === 1) ? 'selected' : ''}}>Especial</option>
													<option value="2" {{(isset($pantalon) && $pantalon->fit_id === 2) ? 'selected' : ''}}>Clásico</option>
													<option value="3" {{(isset($pantalon) && $pantalon->fit_id === 3) ? 'selected' : ''}}>Privanza</option>
												</select>
											</div>
                    					</div>										
									</div>									
								</div>
							</div>
							<div class="row">
								<p class="text-center">Tipo de Pase:</p>
								<div class="col-md-8 col-md-offset-2 text-center">
									<div class="col-md-6 col-md-offset-3">
										<label>
										  <input type="radio" name="tipoPase" value="0" checked="" />
										  <img src="{{ asset('img/suit_options/pantalon/P.Con.Pase.png') }}">
										  <p class="text-center">Con Pase</p>
										</label>
									</div>									
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Número de Pliegues</h4>
									<p class="text-center">Va con dos bolsas frontales en diagonal con vivo</p>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="0" id="sinPliegues" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_0.png') }}">
									  <p class="text-center">Sin Pliegues</p>
									</label>
								</div>
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="1" id="unPliegue" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_1.png') }}">
									  <p class="text-center">1 Pliegue</p>
									</label>
								</div>
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="2" id="dosPliegues" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_2.png') }}">
									  <p class="text-center">2 Pliegues</p>
									</label>
								</div>
							</div>
							<div class="row text-center">
								<h4 class="text-center">Bolsas Traseras</h4>								
								<div class="col-md-6 col-md-offset-3">
									<label>
									  <input type="radio" name="bolsasTraseras" value="2" checked="" />
									  <img src="{{ asset('img/suit_options/pantalon/VivoDoble.png') }}">
									  <p class="text-center">Dos bolsas</p>
									</label>
								</div>
							</div>				
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Interior</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<div class="col-md-12">
										<div class="row">
											<p class="text-center">Color de Bies en Ojalera, Encuarte y Pretina</p>
										</div>
										@include('partials.color-palette', ['varName' => 'OjaleraEncuarte'])
									</div>
									
								</div>
							</div>
							
							<!--Dobladillo-->
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Dobladillo</h4>
								</div>
								<div class="col-md-8 col-md-offset-2 text-center">
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="dobladillo" value="1" id="dobladilloNormal"/>
										  <img src="{{ asset('img/suit_options/pantalon/pantalon.normal.png') }}" >
										  <p class="text-center">Dobladillo Normal</p>
										</label>
									</div>
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="dobladillo" value="2" id="dobladilloValenciana"/>
										  <img src="{{ asset('img/suit_options/pantalon/Pantalon_dobladillo.png') }}">
										  <p class="text-center">Valenciana Española</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
                    			<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Pantalón</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasPantalon" id="notasPantalon" rows="5" class="form-control">@if(isset($pantalon->notas)){{ ucfirst($pantalon->notas) }} @endif</textarea>
		                            </div>
								</div>
							</div>
						</div>
						{{-- Tab Finalizar--}}
						<div class="tab-pane" id="finalizar">
							<!--<div class="col-md-6 col-md-offset-3">
								<h4 class="info-text">
									Estamos a punto de terminar ¡Hurra! Para finalizar, por favor ingresa los datos que se te piden a continuación, si los desconoces, no te preocupes, más tarde puedes volver para llenarlos, así como todos los que hayas dejado en blanco.
								</h4>								
							</div>-->
							                		
	                		<div class="row">
	                			<center><h4>Fin de Orden</h4></center>
	                			<div class="col-md-8 col-md-offset-2">
	                				<p>Al hacer click en <em>Finalizar</em> aceptas haber ingresado los datos correctamente. Recuerda que el pedido una vez aprobado <strong>NO</strong> podrá ser editado por parte del vendedor. Si consideras que existe algún error, o quisieras dejar algún comentario puedes escribir al correo: <a href="mailto:soporte@privanza.com">soporte@privanza.com</a></p>
	                				<p>Se te informará vía alertas de correo electrónico del status de tus órdenes por lo que te recomendamos estar al pendiente del mismo. Si no encuentras las alertas, porfavor revisa tu carpeta de Spam y si el problema persiste, ponte en contacto al correo antes mencionado.</p>
	                				<p>Recuerda que todos los datos que ingresaste al sistema están protegidos por nuestra <a href="#">Política de Uso de Datos</a> y son confidenciales.</p>
	                			</div>
	                		</div>
	                	</div>
						<div class="wizard-footer">
	                    	<div class="pull-right">
	                            <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente'  id="next"/>
	                            <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finalizar' />
	                        </div>
	                        <div class="pull-left">
	                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Anterior' />
	                        </div>
	                        <div class="clearfix"></div>
	                	</div>
                	</div>
            	</form>
        	</div> <!-- wizard container -->
    	</div>
	</div> <!-- row -->
</div>
<script src="{{ asset('wizard/js/orderwizard.js') }}"></script>
{{-- Script para el cambio de imagen cuando es con/sin pickstitch--}}
<script type="text/javascript">
	//var botonSiguiente = document.getElementById('next');

	$("#next").on("click", function() {
    	$("html").scrollTop(0);
    });


    var checkSinAletilla = document.getElementById('sinAletilla');
    function cambiarImagenPickstitch(){
        if ( checkSinAletilla.checked ) {
            document.getElementById('pickstitch').src = "{{ asset('img/suit_options/saco/pick-stitch-saletilla.png') }}";
        }else{
            document.getElementById('pickstitch').src = "{{ asset('img/suit_options/saco/pick-stitch.png') }}";
        }
    }
    checkSinAletilla.addEventListener('click',function(){
        cambiarImagenPickstitch();
    });
	//Código para activar radio buttons en orden dependiendo si la tela es de ISCO o del cliente
	$(document).ready(function(){
		@if(isset($orden->id)) 
			//Condicional para verificar que la orden contiene pantalón y activar esa sección
			@if ($orden->has_pants)
				$('.wizard-card').bootstrapWizard('enable',3);
			@endif
			//Condicional para verificar que la orden contiene chaleco y activar esa sección
			@if ($orden->has_coat) 
				$('.wizard-card').bootstrapWizard('enable',1);
			@endif
			//Condicional para verificar que la orden contiene saco y activar esa sección
			@if ($orden->has_vest) 
				$('.wizard-card').bootstrapWizard('enable',2);
			@endif

			//Ocultar y mostrar datos  
			var telaCliente = document.getElementById('telaCliente');
		    var telaIsco = document.getElementById('telaIsco');
			@if($orden->tela_isco === 0)
        		$('#telaIscoDatos').fadeOut();            		
        		$('#telaClienteDatos').fadeIn();
        		$(telaCliente).addClass('active');
		    @elseif($orden->tela_isco === 1)
		    	$('#telaClienteDatos').fadeOut();
        		$('#telaIscoDatos').fadeIn();        		
        		$(telaIsco).addClass('active');
    		@endif
        	{{-- Código para activar radio buttons en orden dependiendo si el forro es de ISCO o del cliente --}}
        	var forroIsco = document.getElementById('forroIsco');
        	var forroCliente = document.getElementById('forroCliente');
			@if($orden->forro_isco === 0 )
    			$('#forroIscoDatos').fadeOut();            		
    			$('#forroClienteDatos').fadeIn();
    			$(forroCliente).addClass('active');
	    	@elseif($orden->forro_isco === 1 )
	    		$('#forroClienteDatos').fadeOut();
    			$('#forroIscoDatos').fadeIn();        		
    			$(forroIsco).addClass('active');
    		@endif
        	//Cantidad de botones
	    	var divCantidadDeBotones = document.getElementById('cantidadBotones');
	    	//Etiquetas
	    	var divMarcaEtiqueta = document.getElementById('marcaEtiqueta');
	    	var checkMarca = document.getElementById('checkEtiquetaMarca');

	    	var divMarcaTela = document.getElementById('marcaTela');
	    	var checkMarcaTela = document.getElementById('checkEtiquetaTela');
	    	//Gancho y portatrajes
	    	var divPersonalizacionGancho = document.getElementById('personalizacionGancho');
	    	var divPersonalizacionPortatrajes = document.getElementById('personalizacionPortatrajes');
	    	var divPersonalizacionSaco = document.getElementById('personalizacionHolguraSaco');
	    	//Letra
	    	var checkLetraMolde = document.getElementById('letraMolde');
	    	var checkLetraCursiva = document.getElementById('letraCursiva');

	     	@if (isset($orden->id)) 
	    		@if($orden->tipo_botones)
	    			$(divCantidadDeBotones).show();
	    		@endif    	

	    		if (checkMarca.checked){ 
	    			$(divMarcaEtiqueta).show();
	    		}
	    		if (checkMarcaTela.checked){ 
	    			$(divMarcaTela).show();
	    		}
	    		@if ($orden->gancho === 2)
	    			$(divPersonalizacionGancho).show();
	    		@endif
	    		@if ($orden->portatrajes === 2)
	    			$(divPersonalizacionPortatrajes).show();
	    		@endif
	    		@if ($orden->fit_id === 2)
	    			$(divPersonalizacionSaco).show();
	    		@endif

	    		@if($orden->letra === "Molde")
	    			$(checkLetraMolde).attr('checked','checked');
	    		@endif 
	    		@if($orden->letra === "Cursiva")
	    			$(checkLetraCursiva).attr('checked','checked');
	    		@endif
	    	@endif

	    							{{-- Saco --}}
			@if ($orden->has_coat) 
								{{-- Tipo de Solapa--}}
				@if (isset($saco->tipo_solapa) && $saco->tipo_solapa === 0)
					var solapaNormal = document.getElementById('solapaNormal');
					$(solapaNormal).attr('checked','checked');
				@elseif(isset($saco->tipo_solapa) && $saco->tipo_solapa === 1);
					var solapaAncha = document.getElementById('solapaAncha');
					$(solapaAncha).attr('checked','checked');
				@elseif(isset($saco->tipo_solapa) && $saco->tipo_solapa === 2);
					var solapaEscuadraNormal = document.getElementById('solapaEscuadraNormal');
					$(solapaEscuadraNormal).attr('checked','checked');
				@elseif(isset($saco->tipo_solapa) && $saco->tipo_solapa === 3);
					var solapaEscuadraAncha = document.getElementById('solapaEscuadraAncha');
					$(solapaEscuadraAncha).attr('checked','checked');
				@endif
									{{-- Mangas --}}
				//Tipo de ojal 
				@if (isset($saco->tipo_ojal_manga) && $saco->tipo_ojal_manga === 1) 
					var divPosicionOjalesManga = document.getElementById('divPosicionOjalesManga');
					var divSolapaContraste = document.getElementById('solapaContraste');
					$(divPosicionOjalesManga).show();
					$(divSolapaContraste).show();
					@if($saco->color_ojal_solapa || $saco->color_ojal_manga)
						var checkColor = document.getElementById('color<?=$saco->color_ojal_manga?>OjalSolapa');
						var otroColor = document.getElementById('otroColorOjalSolapa');
						$(checkColor).attr('checked','checked');

					@endif
				@endif
				//Ojales Activos 
				@if (isset($saco->ojales_activos_manga) && $saco->ojales_activos_manga )
					var checkOjalesActivosManga = document.getElementById('ojalesActivosManga');
					var divPosicionOjalesActivosManga = document.getElementById('divOjalesActivosManga');
					$(checkOjalesActivosManga).attr('checked','checked');
					$(divPosicionOjalesActivosManga).show();
				@endif
									{{-- Solapa --}}
				//Tipo de ojal
				@if (isset($saco->tipo_ojal_solapa) && $saco->tipo_ojal_solapa === 1) 
					var divSolapaContraste = document.getElementById('solapaContraste');
					$(divSolapaContraste).show();
					@if($saco->color_ojal_solapa || $saco->color_ojal_manga)
						var checkColor = document.getElementById('color<?=$saco->color_ojal_manga?>OjalSolapa');
						var otroColor = document.getElementById('otroColorOjalSolapa');
						$(checkColor).attr('checked','checked');
					@endif					
				@endif
				@if (isset($saco->ojal_activo_solapa) && $saco->ojal_activo_solapa === 1)					
					var checkOjalActivoSolapa = document.getElementById('ojalActivoSolapa');
					$(checkOjalActivoSolapa).attr('checked', 'checked');
				@endif 
				@if(isset($saco->botones_frente))
					@switch($saco->botones_frente)
						@case(1)
								var checkUnBoton = document.getElementById('solapaNormal');
								$(checkUnBoton).attr('checked','checked');
							@break
						@case(2)
								var checkdosBotones = document.getElementById('dosBotones');
								$(checkdosBotones).attr('checked','checked');
							@break
						@case(3)
								var checktresBotones = document.getElementById('tresBotones');
								$(checktresBotones).attr('checked','checked');
							@break
						@case(6)
								var checkseisBotones = document.getElementById('seisBotones');
								$(checkseisBotones).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if(isset($saco->fit_id) && $saco->fit_id === 1)
					$(divPersonalizacionSaco).show();
				@endif
				@if(isset($saco->aberturas_detras))
					@switch($saco->aberturas_detras)
						@case(0)
								var checkSinAberturas = document.getElementById('sinAberturas');
								$(checkSinAberturas).attr('checked','checked');
							@break
						@case(1)
								var checkUnaAbertura = document.getElementById('unaAbertura');
								$(checkUnaAbertura).attr('checked','checked');
							@break
						@case(2)
								var checkdosAberturas = document.getElementById('dosAberturas');
								$(checkdosAberturas).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if (isset($saco->posicion_ojal_manga)) 
					@if($saco->posicion_ojal_manga === 0)
						var botonesCascada = document.getElementById('botonesCascada');
						$(botonesCascada).attr('checked','checked');
					@elseif($saco->posicion_ojal_manga === 1)
						var botonesLinea = document.getElementById('botonesLinea');
						$(botonesLinea).attr('checked','checked');
					@endif				
				@endif
				@if(isset($saco->tipo_bolsas_ext))
					@switch($saco->tipo_bolsas_ext)
						@case(0)
								var parche = document.getElementById('parche');
								$(parche).attr('checked','checked');
							@break
						@case(1)
								var cartera = document.getElementById('cartera');
								$(cartera).attr('checked','checked');
							@break
						@case(2)
								var carteraDiagonal = document.getElementById('carteraDiagonal');
								$(carteraDiagonal).attr('checked','checked');
							@break
						@case(3)
								var vivo = document.getElementById('vivo');
								$(vivo).attr('checked','checked');
							@break
						@case(4)
								var vivoDiagonal = document.getElementById('vivoDiagonal');
								$(vivoDiagonal).attr('checked','checked');
							@break
						@case(5)
								var continental = document.getElementById('continental');
								$(continental).attr('checked','checked');
							@break
						@case(6)
								var continentalDiagonal = document.getElementById('continentalDiagonal');
								$(continentalDiagonal).attr('checked','checked');
							@break
						
					@endswitch
				@endif
				@if (isset($saco->pickstitch)) 
					@if($saco->pickstitch === 1)
						var checkPickstitch = document.getElementById('checkPickstitch');
						$(checkPickstitch).attr('checked','checked');
					@endif				
				@endif
				@if (isset($saco->sin_aletilla)) 
					@if($saco->sin_aletilla === 1)
						$(checkSinAletilla).attr('checked','checked');
					@endif				
				@endif
				@if (isset($saco->tipo_vista)) 
					@if($saco->tipo_vista === 0)
						var checkVistaNormal = document.getElementById('vistaNormal');
						$(checkVistaNormal).attr('checked','checked');
					@elseif($saco->tipo_vista === 1)
						var checkChapetaFrancesa = document.getElementById('chapetaFrancesa');
						$(checkChapetaFrancesa).attr('checked','checked');
					@endif				
				@endif
				@if(isset($saco->bolsas_int))
					@switch($saco->bolsas_int)
						@case(0)
								var CheckOpcUnoBolsasInternas = document.getElementById('CheckOpcUnoBolsasInternas');
								$(CheckOpcUnoBolsasInternas).attr('checked','checked');
							@break
						@case(1)
								var CheckOpcDosBolsasInternas = document.getElementById('CheckOpcDosBolsasInternas');
								$(CheckOpcDosBolsasInternas).attr('checked','checked');
							@break
						@case(2)
								var CheckOpcTresBolsasInternas = document.getElementById('CheckOpcTresBolsasInternas');
								$(CheckOpcTresBolsasInternas).attr('checked','checked');
							@break
						@case(3)
								var CheckOpcCuatroBolsasInternas = document.getElementById('CheckOpcCuatroBolsasInternas');
								$(CheckOpcCuatroBolsasInternas).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if (isset($saco->vivos_bolsas_internas_cuerpo)) 
					@if($saco->vivos_bolsas_internas_cuerpo === 1)
						var checkVivosBolsasInternasCuerpo  = document.getElementById('checkVivosBolsasInternasCuerpo');
						$(checkVivosBolsasInternasCuerpo).attr('checked','checked');
					@endif				
				@endif
				@if(isset($saco->tipo_accesorio))
					var colorPaletteBiesPinpoint = document.getElementById('colorPaletteBiesPinpoint');
					var checkColor = document.getElementById('color<?=$saco->accesorio_color?>Puntada');
					@switch($saco->tipo_accesorio)
						@case(0)
								var tipoAccesorio1 = document.getElementById('tipoAccesorio1');
								$(tipoAccesorio1).attr('checked','checked');
								$(colorPaletteBiesPinpoint).show();
							@break
						@case(1)
								var tipoAccesorio2 = document.getElementById('tipoAccesorio2');
								$(tipoAccesorio2).attr('checked','checked');
								$(colorPaletteBiesPinpoint).show();
							@break
						@case(2)
								var tipoAccesorio3 = document.getElementById('tipoAccesorio3');
								$(tipoAccesorio3).attr('checked','checked');
								$(colorPaletteBiesPinpoint).show();
							@break
					@endswitch
					@if ($saco->accesorio_color) 
						$(checkColor).attr('checked','checked');
					@endif
				@endif
			@endif
								{{-- Chaleco --}}

			@if (isset($orden->has_coat))
				@if(isset($chaleco->tipo_cuello))
					@switch($chaleco->tipo_cuello)
						@case(0)
								var enV = document.getElementById('enV');
								$(enV).attr('checked','checked');
							@break
						@case(1)
								var conSolapa = document.getElementById('conSolapa');
								$(conSolapa).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if(isset($chaleco->tipo_bolsas))
					@switch($chaleco->tipo_bolsas)
						@case(0)
								var vivos = document.getElementById('vivos');
								$(vivos).attr('checked','checked');
							@break
						@case(1)
								var aletilla = document.getElementById('aletilla');
								$(aletilla).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if(isset($chaleco->tipo_espalda))
					@switch($chaleco->tipo_espalda)
						@case(0)
								var espaldaForro = document.getElementById('espaldaForro');
								$(espaldaForro).attr('checked','checked');
							@break
						@case(1)
								var espaldaTela = document.getElementById('espaldaTela');
								$(espaldaTela).attr('checked','checked');
							@break
					@endswitch
				@endif
			@endif 
			@if(isset($orden->has_pants))
				@if(isset($pantalon->pliegues))
					@switch($pantalon->pliegues)
						@case(0)
								var sinPliegues = document.getElementById('sinPliegues');
								$(sinPliegues).attr('checked','checked');
							@break
						@case(1)
								var unPliegue = document.getElementById('unPliegue');
								$(unPliegue).attr('checked','checked');
							@break
						@case(2)
								var dosPliegues = document.getElementById('dosPliegues');
								$(dosPliegues).attr('checked','checked');
							@break
					@endswitch
				@endif
				@if(isset($pantalon->dobladillo))
					@switch($pantalon->dobladillo)
						@case(1)
								var dobladilloNormal = document.getElementById('dobladilloNormal');
								$(dobladilloNormal).attr('checked','checked');
							@break
						@case(2)
								var dobladilloValenciana = document.getElementById('dobladilloValenciana');
								$(dobladilloValenciana).attr('checked','checked');
							@break
					@endswitch
				@endif
			@endif
			@if (isset($orden->has_pants)) 
				@if (isset($pantalon->color_pretina)) 				
					@if($pantalon->color_pretina)
						var checkColor = document.getElementById('color<?=$pantalon->color_pretina?>OjaleraEncuarte');
						$(checkColor).attr('checked','checked');

					@endif
				@endif
			@endif

	    @endif
    });
	
</script>
	
@endsection