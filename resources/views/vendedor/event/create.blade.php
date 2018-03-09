@extends('vendedor.layout.main')

@section('content')
<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
<!-- DateTimePicker JS -->
<script src="{{ asset('js/datepicker.js') }}"></script>
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
                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label class="control-label">Fecha y Hora de la Cita</label>
                                <input type="hidden" id="fechaoculta" name="fechahora" value="@yield('editFecha')">
                                <div id="datetimepicker" data-date="@yield('editFecha')"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <div class="form-group">
                                <label class="control-label">Cliente</label>
                                <select class="form-control" name="cliente" required="true">
                                    <option disabled="" 
                                    @hasSection('editCliente')
                                        {{-- No hay cliente seleccionado --}}
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
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ url('/vendedor/citas') }}" class="btn btn-default">Cancelar</a>
                        </div>
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-success pull-right">Subir</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker({
            inline: true,
            sideBySide: true,
            showTodayButton: true,
            defaultDate: '@yield('editFecha')'
        }).on('dp.change', function () {
            $('#fechaoculta').val($('#datetimepicker').data('DateTimePicker').date().format());
        });
    });
</script>
@endsection