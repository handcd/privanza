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
                <h4 class="title">Añadir Cliente</h4>
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
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Vendedor Asignado</label>
                                <select name="vendedor" id="vendedor" class="form-control">
                                    <option 
                                    @hasSection('editId')
                                        {{-- true expr --}}
                                    @else
                                        selected="" 
                                    @endif
                                    disabled=""></option>
                                    @foreach ($vendedores as $vendedor)
                                        <option 
                                        @hasSection('editId')
                                            @if ($vendedor->id == $cliente->vendedor->id)
                                                selected="true" 
                                            @endif
                                        @endif
                                        value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
                                    @endforeach
                                </select>
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

                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/vendedor/clientes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection