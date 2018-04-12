@extends('validador.layout.main')

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
                <h4 class="title">Añadir Orden de Ajustes</h4>
                <p class="category">Formulario para registrar una nueva Orden de Ajustes nuevo en el sistema</p>
            </div>
            <div class="card-content">
                @hasSection('editId')
                    {{-- No requiere el campo para pre-llenar --}}
                @else
                    <h4>Pre-llenado de campos</h4>
                    <p>Ingresa el Consecutivo de Orden de Producción (si lo hay) para pre-llenar información de los ajustes requeridos.</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Consecutivo de Orden de Producción <small>(opcional)</small>:</label>
                                <input type="text" id="consecutivo_op" name="consecutivo_op" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-info" id="botonop">Buscar Orden de Producción</button>
                        </div>
                    </div>
                @endif
                <form action="{{ url('/validador/ajustes') }}/@yield('editId')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');" novalidate="true">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    <h4>Datos de Ajuste</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Consecutivo de Ajustes:</label>
                                <input type="text" name="consecutivo_ajustes" id="consecutivo_ajustes" value="@yield('editConsecutivoAjuste')" class="form-control" required="true">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Consecutivo de Orden de Producción <small>(opcional)</small>:</label>
                                <input type="text" name="consecutivo_op2" id="consecutivo_op2" value="@yield('editConsecutivoOp')" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Cliente</label>
                                <select name="client_id" id="client_id" class="form-control" required="true">
                                    <option 
                                    @hasSection('editId')
                                        {{-- Nothing --}}
                                    @else
                                        selected="true" 
                                    @endif
                                    disabled=""></option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}"
                                        @hasSection('editId')
                                            @if ($adjustmentOrder->client->id === $cliente->id)
                                                selected="true" 
                                            @endif
                                        @endif
                                        >{{ $cliente->name.' '.$cliente->lastname }} ({{ $cliente->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <a href="/validador/clientes/agregar" class="btn btn-warning">Si el cliente no se encuentra registrado, haz click aquí para registrarlo.</a>
                        </div>
                    </div>
                    
                    <h5>Status Actual del Ajuste</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group label-floating">
                                <label class="control-label">Status Actual de Ajuste</label>
                                <select name="status" id="status" class="form-control" required="true">
                                    <option 
                                    @hasSection('editId')
                                        {{-- Nothing --}}
                                    @else
                                        selected="true"
                                    @endif
                                    disabled=""></option>
                                    <option value="0"
                                    @hasSection('editId')
                                        @if ($adjustmentOrder->status === 0)
                                            selected="true" 
                                        @endif
                                    @endif
                                    >Sin Aprobar</option>
                                    <option value="1"
                                    @hasSection('editId')
                                        @if ($adjustmentOrder->status === 1)
                                            selected="true" 
                                        @endif
                                    @endif
                                    >Aprobado (En proceso)</option>
                                    <option value="2"
                                    @hasSection('editId')
                                        @if ($adjustmentOrder->status === 2)
                                            selected="true" 
                                        @endif
                                    @endif
                                    >Finalizada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <h4>Todos los Ajustes</h4>
                    <button type="button" class="btn btn-success" id="botonajuste">Añadir Ajuste</button>
                    
                    <div id="ajustes-container"></div>

                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/validador/ajustes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/adjustments.js') }}"></script>
@hasSection('editId')
<script type="text/javascript">
    @foreach ($adjustmentOrder->adjustments as $ajuste)
        addAdjustment(
            '{{ $ajuste->promesa_cliente }}',
            '{{ $ajuste->promesa_planta }}',
            {{ $ajuste->num_prendas }},
            '{{ $ajuste->tipo_prenda }}',
            '{{ $ajuste->descripcion }}'
        );
    @endforeach
</script>
@endif

@endsection