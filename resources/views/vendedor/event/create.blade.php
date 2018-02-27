@extends('vendedor.layout.main')

@section('content')
<style>
  .btn{
      white-space:normal !important;
      max-width:500px;
  }
</style>
<div class="row">
    <div class="col-md-12">
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
                <h4 class="title">
                  @hasSection('editId')
                    Editar Cita
                  @else
                    Añadir Cita
                  @endif
                </h4>
                <p class="category">
                  @hasSection('editId')
                    Formulario para editar la cita #@yield('editId')
                  @else
                    Formulario para registrar una cita nueva
                  @endif
                </p>
            </div>
            <div class="card-content">
                <form action="{{ url('/vendedor/citas') }}/@yield('editId')" method="post">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Fecha y Hora de la Cita</label>
                                <input name="fechahora" type="datetime-local" class="form-control"  required="true" value="@yield('editFecha')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
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
                        <div class="col-md-4">
                            <a href="{{ url('/vendedor/clientes/agregar') }}" class="btn btn-warning pull-right">Si el cliente no se encuentra registrado, haz click aquí</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Subir</button>
                    <a href="{{ url('/vendedor/citas') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection