@extends('admin.layout.main')

@section('content')
<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
<!-- DateTimePicker JS -->
<script src="{{ asset('js/datepicker.js') }}"></script>
<div class="row">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h4 class="title">Añadir nuevo Validador</h4>
            <p class="category">Completa la información del nuevo validador</p>
        </div>
        <div class="card-content">
            <form action="{{ url('/admin/validadores') }}/@yield('editId')" method="post">
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
                            <label class="control-label">Posición dentro de ISCO</label>
                            <input  name="job_position" type="text" class="form-control" required="true" value="@yield('editJobPosition')">
                        </div>
                        <div class="form-group label-floating">
                            <label class="control-label">Teléfono</label>
                            <input name="phone" type="phone" class="form-control" required="true" value="@yield('editPhone')">
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <label>Fecha de Nacimiento:</label>
                        <div style="overflow:hidden;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="hidden" id="birthday" name="birthday" value="@yield('editBirthday')">
                                        <div id="datetimepicker"></div>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#datetimepicker').datetimepicker({
                                        inline: true,
                                        format: 'MM/dd/YYYY',
                                        viewMode: 
                                        @hasSection('editBirthday')
                                            'days'
                                        @else
                                            'decades'
                                        @endif
                                        ,
                                        maxDate: 'now',
                                        defaultDate: '@yield('editBirthday')',
                                    }).on('dp.change', () => {
                                        $('#birthday').val($('#datetimepicker').data('DateTimePicker').date().format());
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>

                <h4>Información de la cuenta</h4>
				<div class="row">
					<div class="col-md-4 
                    @hasSection('editId')
                        col-md-offset-4
                    @else
                        col-md-offset-2
                    @endif">
						<p>La cuenta se encuentra:</p>
						<div class="radio">
							<label>
								<input type="radio" name="enabled" value="1" required 
								@hasSection('editId')
                                  @if ($validador->enabled)
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
								@hasSection('editId')
                                  @if (!$validador->enabled)
                                    checked 
                                  @endif 
                                @endif>
								Desactivada
							</label>
						</div>
					</div>
                    @hasSection('editId')
                    @else
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <label class="control-label">Contraseña</label>
                            <input type="text" name="password" class="form-control" required="">
                        </div>
                        <p>
                            <strong>NOTA:</strong> La contraseña que aquí ingreses será la contraseña que el <i>Validador</i> utilizará <strong>sólamente el primer inicio de sesión</strong> posteriormente podrá actualizarla siguiendo el procedimiento de <kbd>Olvidé Mi Contraseña</kbd> durante el inicio de sesión. Esta contraseña <b>NO</b> debe ser algo permanente por lo que sugerimos sea algo simple.
                        </p>
                    </div>
                    @endif
				</div>
                <button type="submit" class="btn btn-success pull-right">Registrar Validador</button>
                <a href="{{ url('/admin/validadores') }}" class="btn btn-default">Cancelar</a>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>  
@endsection