@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-header" data-background-color="purple">
            <h4 class="title">Añadir vendedor</h4>
            <p class="category">Completa la información del nuevo vendedor</p>
        </div>
        <div class="card-content">
            <form action="{{ url('/validador/vendedores') }}/@yield('editId')" method="post">
                {{ csrf_field() }}
                @section('editMethod')
                    @show
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group label-floating">
                            <label class="control-label">Nombre Completo</label>
                            <input name="name" type="text" class="form-control"  required="true" value="@yield('editName')">
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
                    <div class="col-md-8">
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
					<div class="col-md-8 col-md-offset-2">
						<label>La cuenta se encuentra:</label>
						<div class="radio">
							<label>
								<input type="radio" name="enabled" value="1" required 
								@hasSection('editEnabled')
                                  @if ($__env->getSections()['editEnabled'] == "si")
                                    checked 
                                  @endif 
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
				</div>
                <button type="submit" class="btn btn-success pull-right">Registrar Vendedor</button>
                <a href="{{ url('/validador/clientes') }}" class="btn btn-default">Cancelar</a>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>  
@endsection