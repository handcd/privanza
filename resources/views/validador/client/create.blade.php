@extends('validador.layout.main')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Añadir cliente</h4>
                <p class="category">Formulario para registrar un cliente nuevo en el sistema</p>
            </div>
            <div class="card-content">
                <form action="{{ url('/validador/clientes') }}/@yield('editId')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Información General</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre(s)</label>
                                <input name="nombre" type="text" class="form-control"  required="true" value="@yield('editNombreClient')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Apellidos</label>
                                <input  name="apellido" type="text" class="form-control" required="true" value="@yield('editApellidoClient')">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <input name="email" type="email" class="form-control" required="true" value="@yield('editEmailClient')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Teléfono <small>(opcional)</small></label>
                                <input name="phone" type="phone" class="form-control" value="@yield('editPhoneClient')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Fecha de Nacimiento</label>
                                <input name="birthday" required="true" type="date" class="form-control" value="@yield('editBirthdayClient')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label for="addressVisit" class="control-label">Dirección de Visita</label>
                                <input type="text" name="addressVisit" class="form-control" value="@yield('editAddressVisit')" required="true">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label for="addressDelivery" class="control-label">Dirección de Entregas <small>(opcional)</small></label>
                                <input type="text" name="addressDelivery" class="form-control" value="@yield('editAddressDelivery')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Notas del Cliente <small>(opcional)</small></label>
                                <input type="text" name="notas" value="@yield('editNotas')" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Información de Facturación</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="addressLegal" class="control-label">Dirección Fiscal</label>
                                <input type="text" name="addressLegal" class="form-control" value="@yield('editAddressLegal')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="rfc" class="control-label">R.F.C.</label>
                                <input type="text" name="rfc" class="form-control" value="@yield('editRFC')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Últimos 4 dígitos de la cuenta de Banco:</label>
                                <input type="text" maxlength="4" name="digitos" value="@yield('editDigitos')" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="bank" class="control-label">Banco</label>
                                <input type="text" name="bank" class="form-control" value="@yield('editBank')">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating">
                                <label for="concept" class="control-label">Concepto de Facturación</label>
                                <input type="text" name="concept" class="form-control" value="@yield('editConcept')">
                            </div>
                        </div>
                    </div>
                    

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Referencia</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Contacto de Referencia: <small>(opcional)</small></label>
                                <input type="text" name="contactoReferencia" value="@yield('editContactoReferencia')" class="form-control">
                            </div>
                        </div>
                    </div>
                    <h4 class="info-text">Medidas Generales del cliente</h4>
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Altura <small>(En centímetros)</small>:</label>
                                                <input type="number" min="10" step=".01" name="altura" id="altura" value="@yield('editAltura')" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Peso <small>(En kilogramos)</small>:</label>
                                                <input type="number" min="10" step=".01" name="peso" id="peso" value="@yield('editPeso')" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Edad <small>(En años)</small>:</label>
                                                <input type="number" min="10" step="1" name="edad" id="edad" value="@yield('editEdad')" class="form-control">
                                            </div>
                                        </div>                                      
                                    </div>  
                                    <h4 class="info-text">Perfil</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label for="hombros" class="control-label">Hombros:</label>
                                                <select name="hombros" id="hombros" class="form-control">
                                                    <option disabled="" 
                                                    @hasSection('editId')
                                                        {{-- No hay tipo de evento --}}
                                                    @else
                                                        selected="" 
                                                    @endif></option>
                                                    <option value="0">Rectos</option>
                                                    <option value="1">Normales</option>
                                                    <option value="2">Caídos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label for="abdomen" class="control-label">Abdomen:</label>
                                                <select name="abdomen" id="abdomen"  class="form-control">
                                                    <option disabled="" 
                                                    @hasSection('editId')
                                                        {{-- No hay tipo de evento --}}
                                                    @else
                                                        selected="" 
                                                    @endif></option>
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
                                                    <option disabled="" 
                                                    @hasSection('editId')
                                                        {{-- No hay tipo de evento --}}
                                                    @else
                                                        selected="" 
                                                    @endif></option>
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
                                                    <option disabled="" 
                                                    @hasSection('editId')
                                                        {{-- No hay tipo de evento --}}
                                                    @else
                                                        selected="" 
                                                    @endif></option>
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
                                                <input type="number" min="1" step="0.01" name="contornoCuello" id="contornoCuello" value="@yield('editCuello')" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contorno de Biceps <small>(En pulgadas)</small>:</label>
                                                <input type="number" min="1" step="0.01" name="contornoBiceps" id="contornoBiceps" value="@yield('editBiceps')" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Ancho de hombros <small>(En pulgadas)</small>:</label>
                                                <input type="number" min="1" step="0.01" name="medidaHombros" id="medidaHombros" value="@yield('editContornoHombros')" class="form-control">
                                            </div>
                                        </div>      
                                    </div>      
                                    <h4 class="info-text">Largo de brazo <small>(En pulgadas)</small></h4>  
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Brazo derecho:</label>
                                                <input type="number" min="1" step="0.01" name="brazoDerecho" id="brazoDerecho" value="@yield('editBrazoDerecho')" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-md-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Brazo izquierdo:</label>
                                                <input type="number" min="1" step="0.01" name="brazoIzquierdo" id="brazoIzquierdo" value="@yield('editBrazoIzquierdo')" class="form-control">
                                            </div>
                                        </div>                                          
                                    </div>  
                                    <h4 class="info-text">Largo de hombros <small>(En pulgadas)</small></h4>    
                                    <div class="row">
                                        <div class="col-md-4 col-md-offset-2">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Hombro izquierdo:</label>
                                                <input type="number" min="1" step="0.01" name="hombroDerecho" id="hombroDerecho" class="form-control" value="@yield('editHombroDerecho')">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-md-offset-1">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Hombro derecho:</label>
                                                <input type="number" min="1" step="0.01" name="hombroIzquierdo" id="hombroIzquierdo" class="form-control" value="@yield('editHombroIzquierdo')">
                                            </div>
                                        </div>                                          
                                    </div>  
                                    <div class="row">
                                        {{--<div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Ancho espalda:</label>
                                                <input type="number" min="1" step="0.01" name="anchoEspalda" id="anchoEspalda" class="form-control" value="@yield('editAnchoEspalda')">
                                            </div>
                                        </div>--}}
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Largo Torso:</label>
                                                <input type="number" min="1" step="0.01" name="largoTorso" id="largoTorso" class="form-control" value="@yield('editLargoTorso')">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contorno pecho:</label>
                                                <input type="number" min="1" step="0.01" name="contornoPecho" id="contornoPecho" class="form-control" value="@yield('editContornoPecho')">
                                            </div>
                                        </div>  
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Puño:</label>
                                                <input type="number" min="1" step="0.01" name="punio" id="punio" class="form-control" value="@yield('editPunio')">
                                            </div>
                                        </div>      
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Contorno abdomen:</label>
                                                <input type="number" min="1" step="0.01" name="contornoAbdomen" id="contornoAbdomen" class="form-control" value="@yield('editContornoAbdomen')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cintura:</label>
                                                <input type="number" min="1" step="0.01" name="contornoCintura" id="contornoCintura" class="form-control" value="@yield('editCintura')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Cadera:</label>
                                                <input type="number" min="1" step="0.01" name="contornoCadera" id="contornoCadera" class="form-control" value="@yield('editCadera')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Largo tiro:</label>
                                                <input type="number" min="1" step="0.01" name="largoTiro" id="largoTiro" class="form-control" value="@yield('editLargoTiro')">
                                            </div>
                                        </div>
                                    </div>      
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Largo externo pantalón:</label>
                                                <input type="number" min="1" step="0.01" name="largoExternoPantalon" id="largoExternoPantalon" class="form-control" value="@yield('editLargoExterno')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Largo interno pantalón:</label>
                                                <input type="number" min="1" step="0.01" name="largoInternoPantalon" id="largoInternoPantalon" class="form-control" value="@yield('editLargoInterno')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Muslo:</label>
                                                <input type="number" min="1" step="0.01" name="contornoMuslo" id="contornoMuslo" class="form-control" value="@yield('editMuslo')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group label-floating">
                                                <label class="control-label">Rodilla:</label>
                                                <input type="number" min="1" step="0.01" name="contornoRodilla" id="contornoRodilla" class="form-control" value="@yield('editRodilla')">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">¿El cliente presenta hombros disparejos?</label>
                                                <select class="form-control" id="hombroCaido" name="hombroCaido">
                                                    <option disabled="" selected="" ></option>
                                                    <option value="0" {{(isset($orden->hombroCaido) && $orden->hombroCaido === 0) ? 'selected' : ''}}>Hombro derecho caído</option>
                                                    <option value="1" {{(isset($orden->hombroCaido) && $orden->hombroCaido === 1) ? 'selected' : ''}}>Hombro izquierdo caído</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">¿El cliente presenta una conformación de pompas?</label>
                                                <select class="form-control" id="conformacionPompas" name="conformacionPompas">
                                                    <option disabled="" selected="" ></option>
                                                    <option value="0" {{(isset($orden->conformacionPompas) && $orden->conformacionPompas === 0) ? 'selected' : ''}}>Escasas</option>
                                                    <option value="1" {{(isset($orden->conformacionPompas) && $orden->conformacionPompas === 1) ? 'selected' : ''}}>Normales</option>
                                                    <option value="2" {{(isset($orden->conformacionPompas) && $orden->conformacionPompas === 2) ? 'selected' : ''}}>Prominentes</option>
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="col-md-4">
                                            <div class="form-group label-floating">
                                                <label class="control-label">El cliente usa el pantalón...</label>
                                                <select class="form-control" id="usoPantalon" name="usoPantalon">
                                                    <option disabled="" selected="" ></option>
                                                    <option value="0" {{(isset($orden->usoPantalon) && $orden->usoPantalon === 0) ? 'selected' : ''}}>Arriba de la cintura, tiro largo</option>
                                                    <option value="1" {{(isset($orden->usoPantalon) && $orden->usoPantalon === 1) ? 'selected' : ''}}>En la cintura, tiro normal</option>
                                                    <option value="2" {{(isset($orden->usoPantalon) && $orden->usoPantalon === 2) ? 'selected' : ''}}>Abajo de la cintura y/o panza, tiro corto</option>
                                                </select>
                                            </div>
                                        </div>                                                 
                                    </div>
                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/validador/clientes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection