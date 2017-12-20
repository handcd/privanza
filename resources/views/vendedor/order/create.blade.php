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
Estilos para ajustar discrepancias entre Material Dashboard y el Wizard
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
                            <li><a href="#pantalon" data-toggle="tab">Pantalón</a></li>
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
				                                    {{-- No hay tipo de evento --}}
				                                    @else
				                                      selected="" 
				                                    @endif></option>
				                                    @foreach ($clientes as $cliente)
				                                        <option value="{{ $cliente->id }}"
				                                          @hasSection('editCliente')
				                                            @if ($__env->getSections()['editCliente'] == $cliente->id)
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
								<div class="col-md-6">
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
                                            <input type="radio" name="tipoTela" value="isco">
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
								<div class="col-md-6">
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
											Etiquetas de Tela
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaMarca">
											</label>
											Etiquetas de Marca
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
		                            	<label class="control-label">Personalización Gancho: <small>(opcional)</small></label>
		                            	<input type="text" name="perGancho" class="form-control">
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
							}
							label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
							  border:5px solid #55bed5;
							  border-radius: 5px;
							}
						</style>
						<div class="tab-pane" id="sacoExt">
							<h4 class="info-text">Datos de la parte Externa del Saco</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el número de botones:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="1" required="" />
										  <img src="{{ asset('img/suit_options/1botones.png') }}">
										  <p class="text-center">1 Botón</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="2" />
										  <img src="{{ asset('img/suit_options/2botones.png') }}">
										  <p class="text-center">2 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="3" />
										  <img src="{{ asset('img/suit_options/3botones.png') }}">
										  <p class="text-center">3 Botones</p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="6" />
										  <img src="{{ asset('img/suit_options/6botones.png') }}">
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
										  <img src="{{ asset('img/suit_options/0aberturas.png') }}">
										  <p class="text-center">Sin aberturas</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="1" />
										  <img src="{{ asset('img/suit_options/1aberturas.png') }}">
										  <p class="text-center">1 abertura</p>
										</label>
									</div>
									<div class="col-md-4 col-xs-6">
										<label>
										  <input type="radio" name="aberturasDetras" value="2" />
										  <img src="{{ asset('img/suit_options/2aberturas.png') }}">
										  <p class="text-center">2 aberturas</p>
										</label>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el tipo de solapa:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="1" required="" />
										  <img src="{{ asset('img/suit_options/solapa1.png') }}">
										  <p class="text-center">Solapa en Pico <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="2" />
										  <img src="{{ asset('img/suit_options/solapa2.png') }}">
										  <p class="text-center">Solapa en Pico <b>Ancha</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="3" />
										  <img src="{{ asset('img/suit_options/solapa3.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="6" />
										  <img src="{{ asset('img/suit_options/solapa4.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Ancha</b></p>
										</label>
									</div>
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
										<div class="form-group label-floating">
											<label for="" class="control-label">Color para Ojal de Solapa: <small>(opcional)</small></label>
											<input type="text" name="colorOjalSolapa" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Mangas</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label">Botones en Mangas:</label>
											<input type="number" min="1" max="4" step="1" name="botonesMagnas" class="form-control" required="true">
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label class="control-label">Tipo de Ojal en Manga</label>
											<select name="tipoOjalManga" required="true" class="form-control">
												<option disabled="" selected=""></option>
												<option value="0">Al tono</option>
												<option value="1">En contraste</option>
												<option value="2">Activo</option>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group label-floating">
											<label for="" class="control-label">Color para Ojal de Manga: <small>(opcional)</small></label>
											<input type="text" name="colorOjalManga" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<p class="col-md-12">Selecciona la posición de los ojales:</p>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="0" required="" />
											  <img src="{{ asset('img/suit_options/botones_cascada.png') }}">
											  <p class="text-center">Botones en Cascada</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="1" />
											  <img src="{{ asset('img/suit_options/botones_linea.png') }}">
											  <p class="text-center">Botones en Línea</p>
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6 col-sm-offset-3">
										<div class="form-group label-floating">
											<label for="" class="control-label">Número de Ojales Activos en Manga:</label>
											<input type="number" name="ojalesActivosManga" min="0" max="4" step="1" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Bolsas Externas</h4>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtParche">
											</label>
											Bolsas Externas <strong>con</strong> Parche
										</div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtCartera">
											</label>
											Bolsas Externas <strong>con</strong> Cartera
										</div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtVivo">
											</label>
											Bolsas Externas <strong>con</strong> Vivo
										</div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtCarteraDiag">
											</label>
											Bolsas Externas <strong>con</strong> Cartera Diagonal
										</div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtVivoDiag">
											</label>
											Bolsas Externas <strong>con</strong> Vivo Diagonal
										</div>
									</div>
									<div class="col-sm-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="bolsExtCarteraCont">
											</label>
											Bolsas Externas <strong>con</strong> Cartera Continental
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Otros</h4>
									</div>
									<div class="col-md-4 col-md-offset-4">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="pickstitch">
											</label>
											Pick Stitch para Saco
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="sacoInt">
							<h4 class="info-text">Datos de la parte Interna del Saco</h4>
							<div class="row">
								<div class="col-sm-6 col-sm-offset-3">
									<div class="form-group label-floating">
										<label class="control-label">Tipo de Vista</label>
										<select name="tipoOjalSolapa" class="form-control" required="true">
											<option disabled="" selected=""></option>
											<option value="0">Normal</option>
											<option value="1">Chapeta Francesa</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Accesorios</h4>
								</div>
								<div class="col-md-10 col-md-offset-1">
									<div class="col-xs-6">
										<div class="checkbox">
											<label>
												<input name="pinponInterno" type="checkbox">
											</label>
											Pin Pon
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Color Pin Pon <small>(opcional)</small></label>
											<input type="text" class="form-control" name="pinponInternoColor">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Código Pin Pon <small>(opcional)</small></label>
											<input type="text" class="form-control" name="pinponInternoCodigo">
										</div>
									</div>
									<div class="col-xs-6">
										<div class="checkbox">
											<label>
												<input type="checkbox" name="biesInterno">
											</label>
											Bies
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Color Bies <small>(opcional)</small></label>
											<input type="text" class="form-control" name="biesInternoColor">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Código Bies <small>(opcional)</small></label>
											<input type="text" class="form-control" name="biesInternoCodigo">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Bolsas Internas</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="bolsaPechoDer">
										</label>
										Bolsa de Pecho Derecho
									</div>
								</div>
								<div class="col-md-3">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="bolsaPechoIzq">
										</label>
										Bolsa de Pecho Izquierdo
									</div>
								</div>
								<div class="col-md-3">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="cigarrera">
										</label>
										Cigarrera Izquierda
									</div>
								</div>
								<div class="col-md-3">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="plumera">
										</label>
										Plumera Izquierda
									</div>
								</div>
								<div class="col-md-6 col-md-offset-3">
									<div class="form-group label-floating">
										<label class="control-label">Color del Forro para Bolsas Internas <small>(opcional)</small></label>
										<input type="text" class="form-control" name="forroBolsasInt">
									</div>
								</div>
							</div>
						</div>
						
						<div class="tab-pane" id="pantalon">
							<h4 class="info-text">Datos del Pantalón</h4>
							<div class="row">
								<div class="col-md-4">
									<h4 class="text-center">Bolsas Delanteras</h4>
									<div class="form-group label-floating">
										<label class="control-label">Número de Bolsas Delanteras</label>
										<select name="bolsasDelanteras" class="form-control" required="true">
											<option disabled="" selected=""></option>
											<option value="0">Sin Bolsas</option>
											<option value="2">Dos Bolsas</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
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
									<div class="form-group label-floating">
										<label class="control-label">Tipo de Vivo de Bolsas Traseras</label>
										<select name="bolsasTraserasVivo" class="form-control" required="true">
											<option disabled="" selected=""></option>
											<option value="0">Vivo Sencillo</option>
											<option value="1">Vivo Doble</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Cerrado de Bolsas Traseras</h4>
									<div class="form-group label-floating">
										<label class="control-label">Tipo de Cerrado de Bolsas</label>
										<select name="bolsasTraserasCerrado" class="form-control" required="true">
											<option disabled="" selected=""></option>
											<option value="0">Ojal y Botón</option>
											<option value="1">Traba y Botón</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Interior</h4>
								</div>
								<div class="col-md-4">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="ribete">
										</label>
										Ribete en ojalera y encuarte
									</div>
									<div class="form-group label-floating">
										<label class="control-label">Color de Ribete <small>(opcional)</small></label>
										<input type="text" class="form-control" name="colorRibete">
									</div>
								</div>
								<div class="col-md-4">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="forroPiernas">
										</label>
										Medio forro en piernas
									</div>
									<div class="form-group label-floating">
										<label class="control-label">Color de Medio Forro <small>(opcional)</small></label>
										<input type="text" class="form-control" name="colorMedioForro">
									</div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Dobladillo Personalizado</h4>
									<div class="form-group label-floating">
										<label class="control-label">Tipo de Dobladillo</label>
										<select name="tipoDobladillo" class="form-control">
											<option disabled="" selected=""></option>
											<option value="0">Normal</option>
											<option value="1">Valenciana Española</option>
										</select>
									</div>
								</div>
							</div>
						</div>
                    </div>
                	<div class="wizard-footer">
                    	<div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-default btn-wd' name='next' value='Siguiente' />
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
<script type="text/javascript">
    $(document).ready(function(){
    	$('.choice').on("click",function(){
    		if ($(this).attr('id') === 'telaCliente') {
    			$('#telaIscoDatos').fadeOut();
    			$('#telaClienteDatos').fadeIn();
    		} else if($(this).attr('id') === 'telaIsco') {
    			$('#telaClienteDatos').fadeOut();
    			$('#telaIscoDatos').fadeIn();
    		} else if($(this).attr('id') === 'forroCliente') {
    			$('#forroIscoDatos').fadeOut();
    			$('#forroClienteDatos').fadeIn();
    		} else if($(this).attr('id') === 'forroIsco') {
    			$('#forroClienteDatos').fadeOut();
    			$('#forroIscoDatos').fadeIn();
    		}
    	});
    });
</script>
@endsection