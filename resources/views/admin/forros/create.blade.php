@extends('admin.layout.main')

@section('content')
<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
<!-- DateTimePicker JS -->
<script src="{{ asset('js/datepicker.js') }}"></script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<style>
  .btn {
      white-space:normal !important;
      max-width:500px;
  }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Añadir Forro</h4>
                <p class="category">Formulario para registrar un nuevo forro en el sistema</p>
            </div>
            <div class="card-content">
                
                <form action="{{ url('/admin/forros/') }}/@yield('editId')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    <h4>Datos del forro</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Código</label>
                                <input type="text" name="codigo_forro" id="codigoForro" value="@yield('editCodigoForro')" class="form-control" required="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Color</label>
                                <input type="text" name="color_forro" id="colorForro" value="@yield('editColorForro')" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre</label>
                                <input type="text" name="nombre_forro" id="nombreForro" value="@yield('editNombreForro')" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Composición</label>
                                <input type="text" name="composicion" id="composicion" value="@yield('editComposicion')" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Estado</label>
                                <input type="text" name="estado" id="estado" value="@yield('editEstado')" class="form-control">
                            </div>
                        </div>                                
                    </div>
                    
                    
                    <div id="forros-container"></div>

                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/admin/forros') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection