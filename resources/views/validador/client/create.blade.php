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
                <form action="{{ url('/validador/clientes') }}/@yield('editId')" method="post">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre(s)</label>
                                <input name="nombre" type="text" class="form-control"  required="true" value="@yield('editNombreClient')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Apellidos</label>
                                <input  name="apellido" type="text" class="form-control" required="true" value="@yield('editApellidoClient')">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Correo Electrónico</label>
                                <input name="email" type="email" class="form-control" required="true" value="@yield('editEmailClient')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Teléfono</label>
                                <input name="phone" type="phone" class="form-control" value="@yield('editPhoneClient')">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success pull-right">Subir</button>
                    <a href="{{ url('/validador/clientes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection