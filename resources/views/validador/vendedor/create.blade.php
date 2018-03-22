@extends('validador.layout.main')

@section('content')
<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
<!-- DateTimePicker JS -->
<script src="{{ asset('js/datepicker.js') }}"></script>
<div class="row">
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h4 class="title">Añadir nuevo Vendedor</h4>
            <p class="category">Completa la información del nuevo vendedor</p>
        </div>
        <div class="card-content">
            <form action="{{ url('/validador/vendedores') }}/@yield('editId')" method="post">
                {{ csrf_field() }}
                @section('editMethod')
                    @show
                <h4>Datos Generales</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Nombre(s)</label>
                            <input name="name" type="text" class="form-control"  required="true" value="@yield('editName')">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Apellido(s)</label>
                            <input type="text" name="lastname" class="form-control" required="true" value="@yield('editLastname')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Correo Electrónico</label>
                            <input name="email" type="email" class="form-control" required="true" value="@yield('editEmail')">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Dirección</label>
                            <input  name="address" type="text" class="form-control" required="true" value="@yield('editAddress')">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Teléfono</label>
                            <input name="phone" type="phone" class="form-control" required="true" value="@yield('editPhone')">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Fecha de Nacimiento:</label>
                        <div style="overflow:hidden;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" id="birthday" name="birthday" value="@yield('editBirthday')">
                                        <div id="datetimepicker12"></div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#datetimepicker12').datetimepicker({
                                        inline: true,
                                        format: 'MM/dd/YYYY',
                                        viewMode: 'decades',
                                        defaultDate: '@yield('editBirthday')',
                                    }).on('dp.change', () => {
                                        $('#birthday').val($('#datetimepicker12').data('DateTimePicker').date().format());
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <h4>Datos Fiscales <small>(opcionales)</small></h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">RFC</label>
                            <input type="text" class="form-control" value="@yield('editRFC')">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Ùltimos 4 dígitos de la Cuenta</label>
                            <input type="text" class="form-control" value="@yield('editDigits')">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Banco</label>
                            <input type="text" class="form-control" value="@yield('editBank')">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Dirección Legal</label>
                            <input type="text" class="form-control" value="@yield('editLegalAddress')">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Concepto de Facturación</label>
                            <input type="text" class="form-control" value="@yield('editConcept')">
                        </div>
                    </div>
                </div>

                <h4>Información de la cuenta</h4>
				<div class="row">
					<div class="col-md-4 col-md-offset-2">
						<p>La cuenta se encuentra:</p>
						<div class="radio">
							<label>
								<input type="radio" name="enabled" value="1" required 
								@hasSection('editEnabled')
                                  @if ($__env->getSections()['editEnabled'] == "si")
                                    checked 
                                  @endif 
                                @else
                                    checked
                                @endif>
								Activada
							</label>
						</div>
						<div class="radio">
							<label>
								<input type="radio" name="enabled" value="0"
								@hasSection('editAprobado')
                                  @if ($__env->getSections()['editEnabled'] == "no")
                                    checked 
                                  @endif 
                                @endif>
								Desactivada
							</label>
						</div>
					</div>
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Tipo de Vendedor</label>
                            <select name="tipo" id="tipo" required="true" class="form-control">
                                <option disabled="" selected=""></option>
                                <option value="0">Vendedor ISCO</option>
                                <option value="1">Vendedor Externo</option>
                            </select>
                        </div>
                    </div>
				</div>
                <button type="submit" class="btn btn-success pull-right">Registrar Vendedor</button>
                <a href="{{ url('/validador/vendedores') }}" class="btn btn-default">Cancelar</a>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>  
@endsection