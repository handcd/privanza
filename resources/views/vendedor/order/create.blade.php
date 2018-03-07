@extends('vendedor.layout.main')

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
                <form action="{{ url('/vendedor/ordenes') }}/@yield('editId')" method="post">
                	{{ csrf_field() }}
                	@section('editMethod')
                    	@show
            	<!--        You can switch " data-color="blue" "  with one of the next bright colors: "green", "orange", "red", "purple"             -->

                	<div class="wizard-header">
                    	<h3 class="wizard-title">
                    		Añadir Orden
                    	</h3>
						<h5>Formulario para registrar un pedido nuevo</h5>
                	</div>
					<div class="wizard-navigation">
						<ul>
							<li><a href="#inicio" data-toggle="tab">Datos Iniciales</a></li>
                            <li><a href="#sacoExt" data-toggle="tab">Saco Externo</a></li>
                            <li><a href="#sacoInt" data-toggle="tab">Saco Interno</a></li>
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
				                                <select class="form-control" name="cliente" required="true">
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
										<a href="{{ url('/vendedor/clientes/agregar') }}" class="btn btn-warning">
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
	                                          	<input name="codigoTelaCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Tela:</label>
	                                          	<input name="codigoColorTelaCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-arrows-h" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Metros entregados:</label>
	                                          	<input name="mtsTelaCliente" type="number" step="0.1" class="form-control">
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
	                                          	<input name="codigoTelaIsco" type="text" class="form-control">
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
	                                          	<input name="codigoForroCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Forro:</label>
	                                          	<input name="codigoColorForroCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-arrows-h" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Metros entregados:</label>
	                                          	<input name="mtsForroCliente" type="number" step="0.1" class="form-control">
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
	                                          	<input name="codigoForroIsco" type="text" class="form-control">
	                                        </div>
	                                    </div>
                                    </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8 col-md-offset-2">
									<h4 class="text-center">Datos de Botones</h4>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Código de Botones</label>
											<input type="text" name="codigoBoton" required class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Color de Botones</label>
											<input type="text" class="form-control" name="colorBoton" required="">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<h4 class="text-center">Etiquetas</h4>
									<div class="col-md-10 col-md-offset-1">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaTela">
											</label>
											Se Reciben Etiquetas de Tela
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaMarca">
											</label>
											Se Reciben Etiquetas de Marca
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Marca: <small>(opcional: dejar en blanco para Privanza)</small></label>
											<input type="text" class="form-control" name="marcaEtiqueta">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Gancho</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de gancho...</label>
		                                <select class="form-control" name="tipoGancho" required="true">
		                                    <option disabled="" 
		                                    @hasSection('editCliente')
		                                    {{-- No hay tipo de evento --}}
		                                    @else
		                                      selected="" 
		                                    @endif></option>
		                                        <option value="0">Normal</option>
		                                        <option value="1">Personalizado</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating">
		                            	<label class="control-label">Personalización Gancho: <small>(opcional)</small></label>
		                            	<input type="text" name="perGancho" class="form-control">
		                            </div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Portatrajes</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de portatrajes...</label>
		                                <select class="form-control" name="tipoPortatrajes" required="true">
		                                    <option disabled="" 
		                                    @hasSection('editCliente')
		                                    {{-- No hay tipo de evento --}}
		                                    @else
		                                      selected="" 
		                                    @endif></option>
		                                        <option value="0">Cubrepolvos</option>
		                                        <option value="1">Personalizado</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating">
		                            	<label class="control-label">Personalización Portatrajes: <small>(opcional)</small></label>
		                            	<input type="text" name="perPortatrajes" class="form-control">
		                            </div>
								</div>
							</div>
						</div>

						{{-- Saco Externo --}}
						<style>
							label > input{ /* HIDE RADIO */
							  visibility: hidden; /* Makes input not-clickable */
							  position: absolute; /* Remove input from document flow */
							}

							label > input + img{ /* IMAGE STYLES */
							  cursor:pointer;
							  border:4px solid #333;
							  border-radius: 5px;
							  max-width: 250px;
							  max-height: 250px;
							}

							label > input + img + p{
								font-size: 1.2em;
							    font-weight: 200;
							    padding-top: 8px;
							    color: #313034;
							}
							label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
							  border:5px solid #55bed5;
							  border-radius: 5px;
							  filter: opacity(80%) drop-shadow(8px 8px 10px gray);
							}
							
							/* Styles for the color picker images */
							.color-picker img {
								max-width: 50px;
								max-height: 50px;
							}

							.row .col-xs-3:last-child {
								padding-right: 6px !important;
							}
							.row .col-xs-3:first-child {
								padding-left: 6px !important;
							}

							.row .col-xs-6:last-child {
								padding-right: 6px !important;
							}
							.row .col-xs-6:first-child {
								padding-left: 6px !important;
							}

							@media (max-width: 599px) {
								.row .col-xs-3:last-child {
									padding-right: 15px !important;
								}
								.row .col-xs-3:first-child {
									padding-left: 15px !important;
								}

								.row .col-xs-6:last-child {
									padding-right: 15px !important;
								}
								.row .col-xs-6:first-child {
									padding-left: 15px !important;
								}

								label > input + img{ /* IMAGE STYLES */
									max-width: 100px;
									max-height: 100px;
								}
							}
						</style>
						<div class="tab-pane" id="sacoExt">
							<h4 class="info-text">Datos de la parte Externa del Saco</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el tipo de solapa:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="1" required="" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_picodelgado.png') }}">
										  <p class="text-center">Solapa en Pico <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="2" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_PicoAncho.png') }}">
										  <p class="text-center">Solapa en Pico <b>Ancha</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="3" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_Delgado.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="6" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_Ancho.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Ancha</b></p>
										</label>
									</div>
								</div>
								<div class="col-md-10 col-md-offset-1">
									<div class="row">
										<h4 class="col-md-12 text-center">Ojal en Solapa</h4>
										<div class="col-sm-6">
											<div class="form-group label-floating">
												<label class="control-label">Tipo de Ojal en Solapa</label>
												<select name="tipoOjalSolapa" class="form-control" required="true">
													<option disabled="" selected=""></option>
													<option value="0">Sin Ojal en Solapa</option>
													<option value="1">Al tono</option>
													<option value="2">En contraste</option>
													<option value="3">Activo</option>
												</select>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="row">
												<div class="col-md-12">
													<p>Selecciona el color del ojal en solapa:</p>
												</div>
											</div>
											<div class="color-picker">
												<div class="row">
													<div class="col-md-10 col-md-offset-1">
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Negro" />
															  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Gris Oxford" />
															  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Gris Claro" />
															  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Blanco" />
															  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Azul Marino" />
															  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Azul Cielo" />
															  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Rojo" />
															  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
															</label>
														</div>
														<div class="col-xs-3">
															<label>
															  <input type="radio" name="colorOjalSolapa" value="Vino" />
															  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
															</label>
														</div>
													</div>
												</div>
												<div class="form-group label-floating">
													<label for="" class="control-label">Código de Otro Color:</label>
													<input type="text" name="otroColorOjalSolapa" class="form-control">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el número de botones:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="1" required="" />
										  <img src="{{ asset('img/suit_options/saco/Saco_1boton.png') }}">
										  <p class="text-center">1 Botón</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="2" />
										  <img src="{{ asset('img/suit_options/saco/Saco_2botones.png') }}">
										  <p class="text-center">2 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="3" />
										  <img src="{{ asset('img/suit_options/saco/Saco_3botones.png') }}">
										  <p class="text-center">3 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="6" />
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
										  <input type="radio" name="aberturasDetras" value="0" required="" />
										  <img src="{{ asset('img/suit_options/saco/Espalda_SinAberturas.png') }}">
										  <p class="text-center">Sin Aberturas</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="1" />
										  <img src="{{ asset('img/suit_options/saco/Espalda_UnaAbertura.png') }}">
										  <p class="text-center">1 Abertura</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="2" />
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
									<div class="col-sm-6">
										<div class="form-group label-floating">
											<label class="control-label">Botones en Mangas:</label>
											<input type="number" min="1" max="4" step="1" name="botonesMangas" class="form-control" required="true">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group label-floating">
											<label class="control-label">Tipo de Ojal en Manga</label>
											<select name="tipoOjalManga" required="true" class="form-control">
												<option disabled="" selected=""></option>
												<option value="0">Al tono</option>
												<option value="1">En contraste</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-md-offset-3">
										<div class="row">
											<div class="col-md-12">
												<p>Color de Ojal en Mangas:</p>
											</div>
										</div>
										<div class="color-picker">
											<div class="row">
												<div class="col-md-10 col-md-offset-1">
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Negro" />
														  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Gris Oxford" />
														  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Gris Claro" />
														  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Blanco" />
														  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Azul Marino" />
														  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Azul Cielo" />
														  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Rojo" />
														  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjalMangas" value="Vino" />
														  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
														</label>
													</div>
												</div>
											</div>
											<div class="form-group label-floating">
												<label for="" class="control-label">Código de Otro Color:</label>
												<input type="text" name="otroColorOjalMangas" class="form-control">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<p class="col-md-12">Selecciona la posición de los ojales:</p>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="0" required="" />
											  <img src="{{ asset('img/suit_options/saco/Manga_Cascada.png') }}">
											  <p class="text-center">Botones en Cascada</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="1" />
											  <img src="{{ asset('img/suit_options/saco/Manga_Normal.png') }}">
											  <p class="text-center">Botones en Línea</p>
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4 col-sm-offset-4">
										<p class="text-center">Ojales Activos en Manga</p>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="ojalesActivosManga">
												Selecciona para que los ojales sean activos
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
										  <input type="radio" name="bolsasExt" value="0"/>
										  <img src="{{ asset('img/suit_options/saco/Parches.png') }}">
										  <p class="text-center">Parche</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="1"/>
										  <img src="{{ asset('img/suit_options/saco/Cartera.png') }}">
										  <p class="text-center">Cartera</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="2"/>
										  <img src="{{ asset('img/suit_options/saco/CarteraDiagonal.png') }}">
										  <p class="text-center">Cartera en Diagonal</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="3"/>
										  <img src="{{ asset('img/suit_options/saco/Vivos.png') }}">
										  <p class="text-center">Vivo (sin cartera)</p>
										</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="4"/>
										  <img src="{{ asset('img/suit_options/saco/VivosDiagonal.png') }}">
										  <p class="text-center">Vivo Diagonal</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="5"/>
										  <img src="{{ asset('img/suit_options/saco/CarteraContinental.png') }}">
										  <p class="text-center">Cartera Continental</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="6"/>
										  <img src="{{ asset('img/suit_options/saco/CarteraContinentalDiagonal.png') }}">
										  <p class="text-center">Cartera Continental Diagonal</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="bolsasExt" value="7"/>
										  <img src="{{ asset('img/suit_options/saco/SinBolsas.png') }}">
										  <p class="text-center">Sin Bolsas</p>
										</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Otros</h4>
									</div>
									<div class="col-md-6">
										<div class="col-md-6">
											<label>
											  <input type="checkbox" name="pickstitch" />
											  <img src="{{ asset('img/suit_options/saco/pick-stitch.png') }}">
											  <p class="text-center">Pick Stitch para Saco</p>
											</label>
										</div>
										<div class="col-md-6">
											¿Dónde se aplicará el Pick Stitch?
											<div class="checkbox">
												<label>
													<input type="checkbox" name="pickstitchfilos">
													Filos
												</label>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="pickstitchaletilla">
													Aletilla
												</label>
											</div>
											<div class="checkbox">
												<label>
													<input type="checkbox" name="pickstitchcartera">
													Cartera
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										Opciones de Aletilla
										<div class="checkbox">
											<label>
												<input type="checkbox" name="sinaletilla">
												Sin Aletilla
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						{{-- Saco Interno --}}
						<div class="tab-pane" id="sacoInt">
							<h4 class="info-text">Datos de la parte Interna del Saco</h4>
							<div class="row">
								<p class="text-center">Tipo de Vista:</p>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1 text-center">
									<div class="col-md-6 col-xs-6">
										<label>
										  <input type="radio" name="tipoVista" value="0" required="" />
										  <img src="{{ asset('img/suit_options/saco/Chapeta_Normal.png') }}">
										  <p class="text-center">Normal</p>
										</label>
									</div>
									<div class="col-md-6 col-xs-6">
										<label>
										  <input type="radio" name="tipoVista" value="1" />
										  <img src="{{ asset('img/suit_options/saco/Chapeta_Francesa.png') }}">
										  <p class="text-center">Chapeta Francesa</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<h4 class="text-center">Forro Interno en Mangas</h4>
							</div>
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="balsamRayasForroMangas">
											Balsam a Rayas
										</label>
									</div>
								</div>
								<div class="col-md-6 col-md-offset-3">
									<div class="form-group label-floating">
										<label for="" class="control-label">Código de Otro Forro <small>(opcional)</small></label>
										<input type="text" name="otroForroInternoMangas" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<h4 class="text-center">Accesorios</h4>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="col-md-6">
										<div class="row text-center">
											<label>	
											  <input type="checkbox" name="pinPointInterno" />
											  <img src="{{ asset('img/suit_options/saco/pin-point.png') }}">
											  <p class="text-center">Pin Point</p>
											</label>
										</div>
										<div class="row">
											<p class="text-center">Color de Pin Point</p>
										</div>
										<div class="color-picker">
											<div class="row text-center">
												<div class="col-md-10 col-md-offset-1">
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Negro" />
														  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Gris Oxford" />
														  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Gris Claro" />
														  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Blanco" />
														  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Azul Marino" />
														  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Azul Cielo" />
														  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Rojo" />
														  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorPinPointInterno" value="Vino" />
														  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
														</label>
													</div>
												</div>
											</div>
											<div class="form-group label-floating">
												<label for="" class="control-label">Código de Otro Color:</label>
												<input type="text" name="otroColorPinPoint" class="form-control">
											</div>
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Código Pin Point<small>(opcional)</small></label>
											<input type="text" class="form-control" name="pinPointInternoCodigo">
										</div>
									</div>
									<div class="col-md-6">
										<div class="row text-center">
											<label>
											  <input type="checkbox" name="biesInterno" />
											  <img src="{{ asset('img/suit_options/saco/Bies.png') }}">
											  <p class="text-center">Bies</p>
											</label>
										</div>
										<div class="row">
											<p class="text-center">Color de Bies</p>
										</div>
										<div class="color-picker">
											<div class="row text-center">
												<div class="col-md-10 col-md-offset-1">
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Negro" />
														  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Gris Oxford" />
														  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Gris Claro" />
														  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Blanco" />
														  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Azul Marino" />
														  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Azul Cielo" />
														  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Rojo" />
														  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorBies" value="Vino" />
														  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
														</label>
													</div>
												</div>
											</div>
											<div class="form-group label-floating">
												<label for="" class="control-label">Código de Otro Color:</label>
												<input type="text" name="otroColorBies" class="form-control">
											</div>
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Código Bies <small>(opcional)</small></label>
											<input type="text" class="form-control" name="biesInternoCodigo">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<h4 class="text-center">Color de Puntada</h4>
							</div>
							<div class="row">
								<div class="col-md-4 col-md-offset-4">
									<div class="color-picker">
										<div class="row text-center">
											<div class="col-md-10 col-md-offset-1">
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Negro" />
													  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Gris Oxford" />
													  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Gris Claro" />
													  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Blanco" />
													  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Azul Marino" />
													  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Azul Cielo" />
													  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Rojo" />
													  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
													</label>
												</div>
												<div class="col-xs-3">
													<label>
													  <input type="radio" name="colorPuntada" value="Vino" />
													  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
													</label>
												</div>
											</div>
										</div>
										<div class="form-group label-floating">
											<label for="" class="control-label">Código de Otro Color:</label>
											<input type="text" name="otroColorPuntada" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Bolsas Internas</h4>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-3 col-xs-6">
									<label>
									  <input type="radio" name="bolsasInt" value="0"/>
									  <img src="{{ asset('img/suit_options/saco/4Bolsas.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa para pluma, 1 bolsa cigarrera</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-6">
									<label>
									  <input type="radio" name="bolsasInt" value="1"/>
									  <img src="{{ asset('img/suit_options/saco/2Bolsas_Pecho_Plumera.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa para pluma</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-12">
									<label>
									  <input type="radio" name="bolsasInt" value="2"/>
									  <img src="{{ asset('img/suit_options/saco/3Bolsas.png') }}">
									  <p class="text-center">2 bolsas de pecho, 1 bolsa cigarrera</p>
									</label>
								</div>
								<div class="col-md-3 col-xs-12">
									<label>
									  <input type="radio" name="bolsasInt" value="3"/>
									  <img src="{{ asset('img/suit_options/saco/2Bolsas_Pecho.png') }}">
									  <p class="text-center">2 bolsas de pecho</p>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<div class="form-group label-floating">
										<label class="control-label">Código de Color de Forro <small>(opcional)</small></label>
										<input type="text" class="form-control" name="bolsasInternasColor">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-5 col-md-offset-1">
									<div class="row">
										<h5 class="text-center">Vivos en Bolsas Internas</h5>
									</div>
									<div class="row col-xs-offset-1">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="vivosBolsasInternasCuerpo">
												Mismo seleccionado en Cuerpo
											</label>
										</div>
									</div>
									<div class="row col-xs-offset-1">
										<div class="form-group label-floating">
											<label class="control-label">Otro tipo de Vivos <small>(opcional)</small></label>
											<input type="text" class="form-control" name="otroVivosBolsasInternas">
										</div>
									</div>
								</div>
								<div class="col-md-5 col-md-offset-1">
									<div class="row">
										<h5 class="text-center">Puntadas</h5>
									</div>
									<div class="row col-xs-offset-1">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="puntadaFilosSacoInt">
												Puntada en Filos
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="puntadaAletillasSacoInt">
												Puntada en Aletillas
											</label>
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="puntadaCarterasSacoInt">
												Puntada en Carteras
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{-- Tab Chaleco--}}
						<div class="tab-pane" id="chaleco">
                    		<h3 class="info-text">Datos del Chaleco</h3>
                    		<h5 class="info-text">Tipo de Cuello</h5>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
                    				<div class="row">
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="cuelloChaleco" value="0" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_V.png') }}">
											  <p class="text-center">En 'V'</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="cuelloChaleco" value="1" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Solapa.png') }}">
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
											  <input type="radio" name="bolsasChaleco" value="0" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Vivos.png') }}">
											  <p class="text-center">Vivos</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="bolsasChaleco" value="1" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Aletilla.png') }}">
											  <p class="text-center">Aletillas</p>
											</label>
										</div>
									</div>
								</div>
                    		</div>
                    		<h4 class="info-text">Forro o Tela</h4>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
                    				<div class="row">
                    					<div class="col-xs-6">
                    						<label>
                    							<input type="radio" name="forroTela" value="0">
                    							<img src="{{ asset('img/suit_options/chaleco/Chaleco_espalda_forro.png') }}" alt="">
                    							<p class="text-center">Forro</p>
                    						</label>
                    					</div>
                    					<div class="col-xs-6">
                    						<label>
                    							<input type="radio" name="forroTela" value="1">
                    							<img src="{{ asset('img/suit_options/chaleco/Chaleco_Espalda.png') }}" alt="">
                    							<p class="text-center">Tela</p>
                    						</label>
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    		<h4 class="info-text">Opciones Extra</h4>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2 text-center">
            						<label>
									  <input type="checkbox" name="ajustadorChaleco"/>
									  <img src="{{ asset('img/suit_options/chaleco/Chaleco_espalda_ajustador.png') }}">
									  <p class="text-center">Ajustador Espalda</p>
									</label>
                    			</div>
                    		</div>
                    	</div>

                    	{{-- Tab Pantalon --}}
						<div class="tab-pane" id="pantalon">
							<h4 class="info-text">Datos del Pantalón</h4>
							<div class="row">
								<p class="text-center">Tipo de Pase:</p>
								<div class="col-md-8 col-md-offset-2 text-center">
									<div class="col-md-6">
										<label>
										  <input type="radio" name="tipoPase" value="0" />
										  <img src="{{ asset('img/suit_options/pantalon/P.Con.Pase.png') }}">
										  <p class="text-center">Con Pase</p>
										</label>
									</div>
									<div class="col-md-6">
										<label>
										  <input type="radio" name="tipoPase" value="1" />
										  <img src="{{ asset('img/suit_options/pantalon/P.Sin.Pase.png') }}">
										  <p class="text-center">Sin Pase</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Número de Pliegues</h4>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="0" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_0.png') }}">
									  <p class="text-center">Sin Pliegues</p>
									</label>
								</div>
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="1" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_1.png') }}">
									  <p class="text-center">1 Pliegue</p>
									</label>
								</div>
								<div class="col-md-4">
									<label>
									  <input type="radio" name="numPliegues" value="2" />
									  <img src="{{ asset('img/suit_options/pantalon/Pliegues_2.png') }}">
									  <p class="text-center">2 Pliegue</p>
									</label>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 col-md-offset-3">
									<h4 class="text-center">Bolsas Traseras</h4>
									<div class="form-group label-floating">
										<label class="control-label">Número de Bolsas Traseras</label>
										<select name="bolsasTraseras" class="form-control" required="true">
											<option disabled="" selected=""></option>
											<option value="0">Sin bolsas traseras</option>
											<option value="1">Una bolsa trasera</option>
											<option value="2">Dos bolsas traseras</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Tipo de Bolsas Traseras</h4>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-8 col-md-offset-2">
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="tipoVivo" value="1" />
										  <img src="{{ asset('img/suit_options/pantalon/Vivo_Doble_Ojal.png') }}">
										  <p class="text-center">Vivo Doble con Ojal</p>
										</label>
									</div>
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="tipoVivo" value="2" />
										  <img src="{{ asset('img/suit_options/pantalon/VivoSencillo_Ojal.png') }}">
										  <p class="text-center">Vivo Sencillo con Ojal</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Interior</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-md-offset-2">
									<div class="col-md-6">
										<div class="row">
											<p class="text-center">Color de Ojalera y Encuarte</p>
										</div>
										<div class="color-picker">
											<div class="row">
												<div class="col-md-10 col-md-offset-1">
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Negro" />
														  <img src="{{ asset('img/suit_options/colores/negro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Gris Oxford" />
														  <img src="{{ asset('img/suit_options/colores/gris_oxford.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Gris Claro" />
														  <img src="{{ asset('img/suit_options/colores/gris_claro.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Blanco" />
														  <img src="{{ asset('img/suit_options/colores/blanco.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Azul Marino" />
														  <img src="{{ asset('img/suit_options/colores/azul_marino.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Azul Cielo" />
														  <img src="{{ asset('img/suit_options/colores/azul_cielo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Rojo" />
														  <img src="{{ asset('img/suit_options/colores/rojo.png') }}">
														</label>
													</div>
													<div class="col-xs-3">
														<label>
														  <input type="radio" name="colorOjaleraEncuarte" value="Vino" />
														  <img src="{{ asset('img/suit_options/colores/vino.png') }}">
														</label>
													</div>
												</div>
											</div>
											<div class="form-group label-floating">
												<label for="" class="control-label">Código de Otro Color:</label>
												<input type="text" name="otroColorOjaleraEncuarte" class="form-control">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Código Color Medio Forro<small>(opcional)</small></label>
											<input type="text" name="colorMedioForroPiernas" class="form-control">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Dobladillo</h4>
								</div>
								<div class="col-md-8 col-md-offset-2 text-center">
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="dobladillo" value="1" />
										  <img src="{{ asset('img/suit_options/pantalon/pantalon.normal.png') }}">
										  <p class="text-center">Dobladillo Normal</p>
										</label>
									</div>
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="dobladillo" value="2" />
										  <img src="{{ asset('img/suit_options/pantalon/Pantalon_dobladillo.png') }}">
										  <p class="text-center">Valenciana Española</p>
										</label>
									</div>
								</div>
							</div>
						</div>

						{{-- Tab Finalizar--}}
						<div class="tab-pane" id="finalizar">
                    		<h4 class="info-text">Fin de Orden</h4>
                    		<div class="row">
                    			<div class="col-md-8 col-md-offset-2">
                    				<p>Al hacer click en <em>Finalizar</em> aceptas haber ingresado los datos correctamente. Recuerda que el pedido una vez aprobado <strong>NO</strong> podrá ser editado por parte del vendedor. Si consideras que existe algún error, o quisieras dejar algún comentario puedes escribir al correo: <a href="mailto:soporte@privanza.com">soporte@privanza.com</a></p>
                    				<p>Se te informará vía alertas de correo electrónico del status de tus órdenes por lo que te recomendamos estar al pendiente del mismo. Si no encuentras las alertas, porfavor revisa tu carpeta de Spam y si el problema persiste, ponte en contacto al correo antes mencionado.</p>
                    				<p>Recuerda que todos los datos que ingresaste al sistema están protegidos por nuestra <a href="#">Política de Uso de Datos</a> y son confidenciales.</p>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                	<div class="wizard-footer">
                    	<div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-info btn-wd' name='next' value='Siguiente' />
                            <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finalizar' />
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Anterior' />
                        </div>
                        <div class="clearfix"></div>
                	</div>
                </form>
            </div>
        </div> <!-- wizard container -->
    </div>
</div> <!-- row -->
@endsection