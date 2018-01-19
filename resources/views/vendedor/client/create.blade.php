@extends('vendedor.layout.main')

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
                <form action="{{ url('/vendedor/clientes') }}/@yield('editId')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');">
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
                            <h4>Datos del Saco</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="fitSaco" class="control-label">Fit del Saco</label>
                                <select name="fitSaco" class="form-control" required="true">
                                    @hasSection('editFitSaco')
                                        {{-- No hacemos nada --}}
                                    @else
                                        <option disabled="" selected=""></option>
                                    @endif
                                    @foreach ($fits as $fit)
                                        <option value="{{ $fit->id }}" 
                                        @hasSection('editFitSaco')
                                            @if ($__env->getSections()['editFitSaco'] == $fit->id)
                                                selected="" 
                                            @endif
                                        @else
                                            {{-- No hacemos nada --}}
                                        @endif
                                        >{{ $fit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="tallaSaco" class="control-label">Talla del Saco</label>
                                <input type="number" required min="0" step="1" class="form-control" name="tallaSaco" value="@yield('editTallaSaco')" required="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label for="corteSaco" class="control-label">Corte del Saco</label>
                                <select name="corteSaco" class="form-control" required="true">
                                    @hasSection('editCorteSaco')
                                        {{-- No hacemos nada --}}
                                    @else
                                        <option disabled="" selected=""></option>
                                    @endif
                                    <option value="1"
                                    @hasSection('editCorteSaco')
                                        @if ($__env->getSections()['editCorteSaco'] == 1)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Largo</option>
                                    <option value="2"
                                    @hasSection('editCorteSaco')
                                        @if ($__env->getSections()['editCorteSaco'] == 2)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Regular</option>
                                    <option value="3"
                                    @hasSection('editCorteSaco')
                                        @if ($__env->getSections()['editCorteSaco'] == 3)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Corto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo de Manga: <small>(en pulgadas)</small></label>
                                <input type="number" min="0" step="0.01" name="largoManga" class="form-control" required="true" value="@yield('editLargoManga')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo de Espalda: <small>(en pulgadas)</small></label>
                                <input type="number" name="largoEspalda" min="0" step="0.01" class="form-control" required="true" value="@yield('editLargoEspalda')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Notas del Saco:</label>
                                <input type="text" name="notasSaco" class="form-control" value="@yield('editNotasSaco')">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Datos del Chaleco</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Fit del Chaleco:</label>
                                <select name="fitChaleco" class="form-control" required="true">
                                    @hasSection('editFitChaleco')
                                        {{-- No hacemos nada --}}
                                    @else
                                        <option disabled="" selected=""></option>
                                    @endif
                                    @foreach ($fits as $fit)
                                        <option value="{{ $fit->id }}" 
                                        @hasSection('editFitChaleco')
                                            @if ($__env->getSections()['editFitChaleco'] == $fit->id)
                                                selected="" 
                                            @endif
                                        @else
                                            {{-- No hacemos nada --}}
                                        @endif
                                        >{{ $fit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Talla del Chaleco:</label>
                                <input type="number" min="0" step="1" name="tallaChaleco" class="form-control" required="true" value="@yield('editTallaChaleco')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Corte del Chaleco</label>
                                <select name="corteChaleco" class="form-control" required="true">
                                    @hasSection('editCorteChaleco')
                                        {{-- No hacemos nada --}}
                                    @else
                                        <option disabled="" selected=""></option>
                                    @endif
                                    <option value="1"
                                    @hasSection('editCorteChaleco')
                                        @if ($__env->getSections()['editCorteChaleco'] == 1)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Largo</option>
                                    <option value="2"
                                    @hasSection('editCorteChaleco')
                                        @if ($__env->getSections()['editCorteChaleco'] == 2)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Regular</option>
                                    <option value="3"
                                    @hasSection('editCorteChaleco')
                                        @if ($__env->getSections()['editCorteChaleco'] == 3)
                                            selected="" 
                                        @endif
                                    @else
                                        {{-- No hacemos nada --}}
                                    @endif>Corto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo de Espalda Chaleco:</label>
                                <input type="number" min="0" step="0.1" name="largoEspaldaChaleco" value="@yield('editlargoEspaldaChaleco')" class="form-control" required="true">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Notas del Chaleco:</label>
                                <input type="text" name="notasChaleco" value="@yield('editNotasChaleco')" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Datos del Pantalón</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Fit del Pantalón:</label>
                                <select name="fitPantalon" class="form-control" required="true">
                                    @hasSection('editFitPantalon')
                                        {{-- No hacemos nada --}}
                                    @else
                                        <option disabled="" selected=""></option>
                                    @endif
                                    @foreach ($fits as $fit)
                                        <option value="{{ $fit->id }}" 
                                        @hasSection('editFitPantalon')
                                            @if ($__env->getSections()['editFitPantalon'] == $fit->id)
                                                selected="" 
                                            @endif
                                        @else
                                            {{-- No hacemos nada --}}
                                        @endif
                                        >{{ $fit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Talla del Pantalón:</label>
                                <input type="number" min="0" step="1" name="tallaPantalon" class="form-control" required="true" value="@yield('editTallaPantalon')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo Externo Terminado: <small>(en pulgadas)</small></label>
                                <input type="number" name="largoExtPantalon" min="0" step="0.01" class="form-control" required="true" value="@yield('editLargoExtPantalon')">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Largo Interno Terminado: <small>(en pulagadas)</small></label>
                                <input type="number" min="0" step="0.01" name="largoIntPantalon" class="form-control" required="true" value="@yield('editLargoIntPantalon')">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating">
                                <label class="control-label">Notas del Pantalón: <small>(opcional)</small></label>
                                <input type="text" name="notasPantalon" class="form-control" value="@yield('editNotasPantalon')">
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

                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/vendedor/clientes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection