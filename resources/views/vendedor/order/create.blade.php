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
                            <!--<li><a href="#medidas" data-toggle="tab">Medidas</a></li>!-->
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
				                                <select class="form-control" name="cliente" ue">
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
	                                          	<input name="codigoTelaCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre de la tela:</label>
	                                          	<input name="nombreTela" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Tela:</label>
	                                          	<input name="codigoColorTelaCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Color de Tela:</label>
	                                          	<input name="colorTelaCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-arrows-h" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Metros entregados:</label>
	                                          	<input name="mtsTelaCliente" type="number" step="0.1" class="form-control" min="0">
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
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre de la tela:</label>
	                                          	<input name="nombreTelaIsco" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Tela:</label>
	                                          	<input name="codigoColorTelaIsco" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Color de Tela:</label>
	                                          	<input name="colorTelaIsco" type="text" class="form-control">
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
	                                          	<label class="control-label">Nombre del Forro:</label>
	                                          	<input name="nombreForroCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Forro:</label>
	                                          	<input name="codigoColorForroCliente" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Color del Forro:</label>
	                                          	<input name="colorForroCliente" type="text" class="form-control">
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
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Nombre del Forro:</label>
	                                          	<input name="nombreForroIsco" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-barcode" aria-hidden="true"></i>
											</span>
	                                        <div class="form-group label-floating">
	                                          	<label class="control-label">Código de Color de Forro:</label>
	                                          	<input name="codigoColorForroIsco" type="text" class="form-control">
	                                        </div>
	                                    </div>
	                                    <div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-pencil" aria-hidden="true"></i>
											</span>
	                                    	<div class="form-group label-floating">
	                                          	<label class="control-label">Color del Forro:</label>
	                                          	<input name="colorForroIsco" type="text" class="form-control">
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
											<input type="checkbox" name="botonesCliente" id="botonesCliente">
										</label>
										Botones de cliente
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Código de Botones</label>
											<input type="text" name="codigoBotones" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Código de color de Botones</label>
											<input type="text" name="codigoColorBotones" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Color de Botones</label>
											<input type="text" class="form-control" name="colorBotones">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating" id="cantidadBotones">
											<label for="" class="control-label">Cantidad de botones</label>
											<input type="number" class="form-control" name="cantidadBotones">
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
												<input type="checkbox" name="etiquetaTela">
											</label>
											Se Reciben Etiquetas de Tela
										</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="etiquetaMarca" id="checkEtiquetaMarca">
											</label>
											Se Reciben Etiquetas de Marca
										</div>										
										<div class="form-group label-floating" id="marcaEtiqueta">
											<label class="control-label">Ingrese la marca:</small></label>
											<input type="text" class="form-control" name="marcaEtiqueta">
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Gancho</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de gancho...</label>
		                                <select class="form-control" id="tipoGancho" name="tipoGancho">
		                                    <option disabled="" 
		                                    @hasSection('editCliente')
		                                    {{-- No hay tipo de evento --}}
		                                    @else
		                                      selected="" 
		                                    @endif></option>
		                                        <option value="0">Normal</option>
		                                        <option value="1">Personalizado Privanza</option>
		                                        <option value="2">Otro</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating" id="personalizacionGancho">
		                            	<label class="control-label">Personalización Gancho: <small>(opcional)</small></label>
		                            	<input type="text" name="perGancho" class="form-control">
		                            </div>
								</div>
								<div class="col-md-4">
									<h4 class="text-center">Portatrajes</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Tipo de portatrajes...</label>
		                                <select class="form-control" id="tipoPortatrajes" name="tipoPortatrajes">
		                                    <option disabled="" 
		                                    @hasSection('editCliente')
		                                    {{-- No hay tipo de evento --}}
		                                    @else
		                                      selected="" 
		                                    @endif></option>
		                                        <option value="0">Cubrepolvos</option>
		                                        <option value="1">Personalizado Privanza</option>
		                                        <option value="2">Otro</option>
		                                </select>
		                            </div>
		                            <div class="form-group label-floating" id="personalizacionPortatrajes">
		                            	<label class="control-label">Personalización Portatrajes: <small>(opcional)</small></label>
		                            	<input type="text" name="perPortatrajes" class="form-control">
		                            </div>
								</div>								
							</div>
							{{-- Bordado de iniciales--}}
							<div class="row">
								<h4 class="text-center">Bordado de iniciales (opcional)</h4>
								<div class="col-md-4 col-md-offset-4">											
									<div class="form-group label-floating">
										<label class="control-label">Nombre <small>(Máximo 10 caracteres, los puntos también cuentan):</small></label>
		                            	<input type="text" name="bordadoNombre" class="form-control" maxlength="10">
		                            </div>
									<div class="row text-center">
										<div class="col-xs-3 col-xs-offset-3">
											<label>
			  									<input type="radio" name="letra" value="Molde" />
			  									<img src="{{ asset('img/suit_options/letras/bordado_molde.png') }}">
			  									<p>Letra de molde</p>
											</label>									
										</div>
										<div class="col-xs-3">
											<label>
			  									<input type="radio" name="letra" value="Cursiva" />
			  									<img src="{{ asset('img/suit_options/letras/bordado_cursiva.png') }}">
			  									<p>Letra cursiva</p>
											</label>
										</div>										
									</div>									
										<p>El color por defecto para el bordado es gris plata, si desea un color distinto, colóquelo abajo</p>									
									<div class="form-group label-floating">
										<label class="control-label">Otro Color <small>(opcional)</small>:</label>
		                            	<input type="text" name="bordadoColor" class="form-control">
		                            </div>	
		                            <div class="row">
									<center><h4>Notas del Bordado</h4></center>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasBordado"  rows="2" class="form-control"></textarea>
		                            </div>
								</div>
								</div>
								
							</div>
						</div>

						{{-- Medidas del cliente --}}
						
						<div class="tab-pane" id="medidas">
							<h4 class="info-text">Medidas Generales del cliente</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Altura <small>(En centímetros)</small>:</label>
												<input type="number" min="10" step="1" name="altura" id="altura" class="form-control">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Peso <small>(En kilogramos)</small>:</label>
												<input type="number" min="10" step=".1" name="peso" id="peso" class="form-control">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Edad <small>(En años)</small>:</label>
												<input type="number" min="10" step="1" name="edad" id="edad" class="form-control">
											</div>
										</div>										
									</div>	
									<h4 class="info-text">Perfil</h4>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="hombros" class="control-label">Hombros:</label>
												<select name="hombros" id="hombros" class="form-control">
													<option disabled="" selected=""></option>
													<option value="0">Rectos</option>
													<option value="1">Normales</option>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="abdomen" class="control-label">Abdomen:</label>
												<select name="abdomen" id="abdomen" class="form-control">
													<option disabled="" selected=""></option>
													<option value="0">Delgado</option>
													<option value="1">Normal</option>
													<option value="2">Voluminoso</option>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="pecho" class="control-label">Pecho:</label>
												<select name="pecho" id="pecho" class="form-control">
													<option disabled="" selected=""></option>
													<option value="0">Musculoso</option>
													<option value="1">Normal</option>
													<option value="2">Curpulento</option>
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label for="espalda" class="control-label">Espalda:</label>
												<select name="espalda" id="espalda" class="form-control">
													<option disabled="" selected=""></option>
													<option value="0">Recta</option>
													<option value="1">Normal</option>
													<option value="2">Encorvada</option>
												</select>
											</div>
										</div>																
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Contorno de cuello <small>(En pulgadas)</small>:</label>
												<input type="number" min="1" step="0.1" name="contornoCuello" id="contornoCuello" class="form-control">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Contorno de Biceps <small>(En pulgadas)</small>:</label>
												<input type="number" min="1" step="0.1" name="contornoBiceps" id="contornoBiceps" class="form-control">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group label-floating">
												<label class="control-label">Medida de hombros <small>(En pulgadas)</small>:</label>
												<input type="number" min="1" step="0.1" name="medidaHombros" id="medidaHombros" class="form-control">
											</div>
										</div>		
									</div>		
									<h4 class="info-text">Largo de brazo <small>(En pulgadas)</small></h4>	
									<div class="row">
										<div class="col-md-4 col-md-offset-2">
											<div class="form-group label-floating">
												<label class="control-label">Brazo derecho:</label>
												<input type="number" min="1" step="0.1" name="brazoDerecho" id=brazoDerecho" class="form-control">
											</div>
										</div>
										<div class="col-md-4 col-md-offset-1">
											<div class="form-group label-floating">
												<label class="control-label">Brazo izquierdo:</label>
												<input type="number" min="1" step="0.1" name="brazoIzquierdo" id="brazoIzquierdo" class="form-control">
											</div>
										</div>											
									</div>	
									<h4 class="info-text">Largo de hombros <small>(En pulgadas)</small></h4>	
									<div class="row">
										<div class="col-md-4 col-md-offset-2">
											<div class="form-group label-floating">
												<label class="control-label">Hombro izquierdo:</label>
												<input type="number" min="1" step="0.1" name="hombroDerecho" id=hombroDerecho" class="form-control">
											</div>
										</div>
										<div class="col-md-4 col-md-offset-1">
											<div class="form-group label-floating">
												<label class="control-label">Hombro derecho:</label>
												<input type="number" min="1" step="0.1" name="hombroIzquierdo" id="hombroIzquierdo" class="form-control">
											</div>
										</div>											
									</div>	
									<div class="row">
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Ancho espalda:</label>
												<input type="number" min="1" step="0.1" name="anchoEspalda" id="anchoEspalda" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Largo Torso:</label>
												<input type="number" min="1" step="0.1" name="largoTorso" id="largoTorso" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Contorno pecho:</label>
												<input type="number" min="1" step="0.1" name="contornoPecho" id="contornoPecho" class="form-control">
											</div>
										</div>	
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Puño:</label>
												<input type="number" min="1" step="0.1" name="punio" id="punio" class="form-control">
											</div>
										</div>		
									</div>	
									<div class="row">
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Contorno abdomen:</label>
												<input type="number" min="1" step="0.1" name="contornoAbdomen" id="contornoAbdomen" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Cintura:</label>
												<input type="number" min="1" step="0.1" name="contornoCintura" id="contornoCintura" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Cadera:</label>
												<input type="number" min="1" step="0.1" name="contornoCadera" id="contornoCadera" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Largo tiro:</label>
												<input type="number" min="1" step="0.1" name="largoTiro" id="largoTiro" class="form-control">
											</div>
										</div>
									</div>		
									<div class="row">
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Largo externo pantalón:</label>
												<input type="number" min="1" step="0.1" name="largoExternoPantalon" id="largoExternoPantalon" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Largo interno pantalón:</label>
												<input type="number" min="1" step="0.1" name="largoInternoPantalon" id="largoInternoPantalon" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Muslo:</label>
												<input type="number" min="1" step="0.1" name="contornoMuslo" id="contornoMuslo" class="form-control">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group label-floating">
												<label class="control-label">Rodilla:</label>
												<input type="number" min="1" step="0.1" name="contornoRodilla" id="contornoRodilla" class="form-control">
											</div>
										</div>
									</div>									
								</div>	
							</div>
						</div>

						{{-- Medidas del cliente --}}	
						
						{{-- Saco Interno --}}
						<div class="tab-pane" id="saco">
							<h4 class="info-text">Datos de la parte Externa del Saco</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p>Observaciones generales del cliente:</p>
										<div class="col-md-6 ">
										
											<div class="form-group label-floating">
												<label class="control-label">Fit deseado</label>
												<select name="fitSaco" id="fitSaco" class="form-control">
													<option disabled="" selected=""></option>
													@foreach (\App\Fit::all() as $fit)
														<option value="{{ $fit->id }}">{{ $fit->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label class="control-label">Largo de manga deseado:</label>
												<input type="number" min="10" step="1" name="tallaSaco" id="tallaSaco" class="form-control">
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
										  <input type="radio" name="tipoSolapa" value="0" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_picodelgado.png') }}">
										  <p class="text-center">Solapa en Pico <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="1" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_PicoAncho.png') }}">
										  <p class="text-center">Solapa en Pico <b>Ancha</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="2" />
										  <img src="{{ asset('img/suit_options/saco/Cuello_Delgado.png') }}">
										  <p class="text-center">Solapa en Escuadra <b>Normal</b></p>
										</label>
									</div>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="tipoSolapa" value="3" />
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
											<option disabled="" selected=""></option>
											<option value="0">Al tono</option>
											<option value="1">En contraste</option>
										</select>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="ojalesActivosManga" id="ojalesActivosManga">
											Selecciona para que el ojal sea activo
										</label>
									</div>
									<div class="form-group label-floating" id="divOjalesActivosManga">
	                                		<label class="control-label">Posición de Ojales Activos</label>
	                                		<select class="form-control" name="posicionOjalesActivosManga">
			                                    <option disabled="" 
			                                    @hasSection('editCliente')
			                                    {{-- Ya hay un cliente seleccionado --}}
			                                    @else
			                                      selected="" 
			                                    @endif></option>
			                                    <option value="0"> 4</option>
			                                    <option value="3"> 3 y 4</option>
			                                    <option value="1"> 2, 3, 4 </option>
			                                    <option value="2"> Todos</option>
			                                </select>	                                		
	                            	</div>			                            	
								</div>		
								
								<div class="col-sm-4 col-sm-offset-1">
									<h5 class="text-center">Solapa</h5>
									<div class="form-group label-floating">
										<label class="control-label">Color de ojal en Solapa</label>
										<select name="tipoOjalSolapa" class="form-control" ue" id="ojalEnSolapa">
											<option disabled="" selected=""></option>
											<option value="1">Al tono</option>
											<option value="2">En contraste</option>
										</select>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="ojalActivoSolapa">
											Selecciona para que el ojal sea activo
										</label>
									</div>
								</div>					
							</div>
						</div>
						<div class="col-md-10 col-sm-offset-1">
							<div class="col-md-6">
								<img src="{{ asset('img/suit_options/saco/Manga_Normal.jpg') }}" alt="Imágen de Indicador de Botones">
							</div>		
							<div class="col-sm-6" id="solapaContraste">
								{{--<div class="row">--}}
										<p>Selecciona el color del ojal en solapa:</p>
									
									@include('partials.color-palette', ['varName' => 'OjalSolapa'])
								{{--</div>--}}										
							</div>									
						</div>




							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p class="col-md-12">Selecciona el número de botones:</p>
									<div class="col-md-3 col-xs-6">
										<label>
										  <input type="radio" name="botonesFrente" value="1" />
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
										  <input type="radio" name="aberturasDetras" value="0" />
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
									<div class="col-sm-6 col-sm-offset-3">
										<div class="form-group label-floating">
											<label class="control-label">Botones en Mangas:</label>
											<select name="botonesMangas" id="botonesMangas" class="form-control" ue">
												<option disabled="" selected=""></option>
												<option value="1">1 Botón</option>
												<option value="2">2 Botones</option>
												<option value="3">3 Botones</option>
												<option value="4">4 Botones</option>
											</select>
										</div>
									</div>
									
								</div>
								
								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<p class="col-md-12">Selecciona la posición de los ojales:</p>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="posicionOjalesManga" value="0" />
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
								</div>
								<div class="row">
									<div class="col-md-12">
										<h4 class="text-center">Otros</h4>
									</div>
									<div class="col-md-6 text-center">
										<label>
										  <input type="checkbox" name="pickstitch" />
										  <img src="{{ asset('img/suit_options/saco/pick-stitch.png') }}">
										  <p class="text-center">Pick Stitch para Saco (Se incluye en filos, aletilla y cartera)</p>
										</label>
									</div>
									<div class="col-md-6">
										<p>
											Opciones de Aletilla
											<small>(Por defecto lo confeccionamos con aletilla normal)</small>
										</p>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="sinaletilla">
												Sin Aletilla
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<h4>Notas del Saco Externo</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasSacoExt" id="notasSacoExt" rows="5" class="form-control"></textarea>
		                            </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1 text-center">
									<h4 class="info-text">Datos de la parte Interna del Saco</h4>
									<p class="text-center">Tipo de Vista:</p>
									<div class="col-md-6 col-xs-6">
										<label>
										  <input type="radio" name="tipoVista" value="0" />
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
								<div class="col-xs-3 col-xs-offset-5">
									<div class="row">
										<h5 class="text-center">Vivos en Bolsas Internas</h5>
									</div>
										<div class="checkbox">
											<label>
												<input type="checkbox" name="vivosBolsasInternasCuerpo">
												Del mismo forro en cuerpo	
											</label>
										</div>
										<div class="form-group label-floating">
											<label class="control-label">En contraste a otro tono <small>(opcional)</small></label>
											<input type="text" class="form-control" name="otroVivosBolsasInternas">
										</div>
								</div>
								
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Saco Interno</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasSacoInt" id="notasSacoInt" rows="5" class="form-control"></textarea>
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
													<option disabled="" selected=""></option>
													@foreach (\App\Fit::all() as $fit)
														<option value="{{ $fit->id }}">{{ $fit->name }}</option>
													@endforeach
												</select>
											</div>
                    					</div>
                    					<div class="col-md-6">
                    						<div class="form-group label-floating">
                    							<label class="control-label">Largo de espalda deseado:</label>
                    							<input type="number" min="10" step="1" name="tallaChaleco" id="tallaChaleco" class="form-control">
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
											  <input type="radio" name="cuelloChaleco" value="0" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_V.png') }}">
											  <p class="text-center">En 'V'</p>
											</label>
										</div>
										<div class="col-xs-6">
											<label>
											  <input type="radio" name="cuelloChaleco" value="1" />
											  <img src="{{ asset('img/suit_options/chaleco/Chaleco_Solapa.jpg') }}">
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
										<input type="text" class="form-control" name="codigoOtroForroChaleco">
									</div>
                    			</div>
                    		</div>
                    		
                    		<div class="row">
                    			<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Chaleco</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasChaleco" id="notasChaleco" rows="5" class="form-control"></textarea>
		                            </div>
								</div>
							</div>
                    	</div>

                    	{{-- Tab Pantalón --}}
						<div class="tab-pane" id="pantalon">
							<h4 class="info-text">Datos del Pantalón</h4>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<p>Observaciones generales del cliente:</p>
									<div class="row">
										<div class="col-md-6">
                    						<div class="form-group label-floating">
												<label class="control-label">Fit para Pantalón</label>
												<select name="fitPantalon" id="fitPantalon" class="form-control">
													<option disabled="" selected=""></option>
													@foreach (\App\Fit::all() as $fit)
														<option value="{{ $fit->id }}">{{ $fit->name }}</option>
													@endforeach
												</select>
											</div>
                    					</div>
										<div class="col-md-6">
											<div class="form-group label-floating">
												<label class="control-label">Talla del Pantalón:</label>
												<input type="number" min="10" step="1" name="tallaPantalon" id="tallaPantalon" class="form-control">
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
									{{--<div class="col-md-6">
										<label>
										  <input type="radio" name="tipoPase" value="1" />
										  <img src="{{ asset('img/suit_options/pantalon/P.Sin.Pase.png') }}">
										  <p class="text-center">Sin Pase</p>
										</label>
									</div>--}}
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
									  <p class="text-center">2 Pliegues</p>
									</label>
								</div>
							</div>
							<div class="row text-center">
								<h4 class="text-center">Bolsas Traseras</h4>
								{{--<div class="col-md-4 col-md-offset-2">
									<label>
									  <input type="radio" name="bolsasTraseras" value="1" />
									  <img src="{{ asset('img/suit_options/numero_bolsas/PantalonUnaBolsa.png') }}">
									  <p class="text-center">Una bolsa</p>
									</label>
								</div>--}}
								<div class="col-md-6 col-md-offset-3">
									<label>
									  <input type="radio" name="bolsasTraseras" value="2" checked="" />
									  <img src="{{ asset('img/suit_options/numero_bolsas/PantalonDosBolsas.png') }}">
									  <p class="text-center">Dos bolsas</p>
									</label>
								</div>
							</div>							
							{{--<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Tipo de Bolsas Traseras</h4>
								</div>
							</div>
							<div class="row text-center">
								<div class="col-md-8 col-md-offset-2">
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="tipoVivo" value="1" />
										  <img src="{{ asset('img/suit_options/pantalon/VivoDobleOjal.png') }}">
										  <p class="text-center">Vivo Doble con Ojal</p>
										</label>
									</div>
									<div class="col-xs-6">
										<label>
										  <input type="radio" name="tipoVivo" value="2" />
										  <img src="{{ asset('img/suit_options/pantalon/VivoSencilloOjal.png') }}">
										  <p class="text-center">Vivo Sencillo con Ojal</p>
										</label>
									</div>
								</div>
							</div>--}}
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Interior</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1">
									<div class="col-md-6">
										<div class="row">
											<p class="text-center">Color de Bies en Ojalera, Encuarte y Pretina</p>
										</div>
										@include('partials.color-palette', ['varName' => 'OjaleraEncuarte'])
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
		                                	<div class="form-group label-floating">
												<div class="checkbox">
													<label><input type="checkbox" name="medioForroPiernasAlTono" value="true">Medio Forro interior al tono</label>
												</div>								
											</div>											
										</div>
										<div class="form-group label-floating">									
												<label for="" class="control-label">Código de otro color<small></small></label>
												<input type="text" name="codigoOtroColorMedioForro" class="form-control">		
										</div>
										<div class="form-group label-floating">									
												<label for="" class="control-label">Color<small></small></label>
												<input type="text" name="otroColorMedioForro" class="form-control">		
										</div>										
									</div>
								</div>
							</div>
							<!-- Pretina-->
							{{--
							<div class="row">
								<div class="col-md-12">
									<h4 class="text-center">Pretina</h4>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8 col-md-offset-2">
									<div class="col-md-6">
										<div class="form-group label-floating">
											<label for="" class="control-label">Tipo de pretina</label>
											<select class="form-control" name="pretina" ue">
													<option disabled="" 
					                                    @hasSection('editCliente')
					                                    Ya hay un cliente seleccionado 
					                                    @else
					                                      selected="" 
					                                    @endif></option>
			                                    	<option value="0">Flexon</option>
	  												<option value="1">Snutex</option>
	  												<option value="2">Bies</option>
			                                </select>										
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group label-floating">
											<div class="checkbox">
												<label><input type="checkbox" name="colorBiesPretina" value="colorOjaleraEncuarte"> Bies del mismo color Ojalera y Encuarte</label>
											</div>									
										</div>
										<div class="form-group label-floating">									
												<label for="" class="control-label">Código de otro color de Pretina<small>(opcional)</small></label>
												<input type="text" name="otroColorBiesPretina" class="form-control">		
										</div>
									</div>
									
								</div>
							</div>--}}
							<!--Dobladillo-->
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
							<div class="row">
                    			<div class="col-md-10 col-md-offset-1">
									<h4>Notas del Pantalón</h4>
									<div class="form-group label-floating">
		                                <label class="control-label">Notas que puedan ayudar a tener una mejor idea de lo que quiere el cliente...</label>
		                                <textarea name="notasPantalon" id="notasPantalon" rows="5" class="form-control"></textarea>
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
<script src="{{ asset('wizard/js/orderwizard.js') }}"></script>

@endsection