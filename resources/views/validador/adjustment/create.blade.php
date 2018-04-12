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
<script>
// Generación de Ajuste
const ajusteContainer = document.getElementById('ajustes-container');
var noAjustes = 0;

function addAdjustment(fechaCliente = '', fechaPlanta = '', noPrendas = '', tipoPrenda = '', descripcion = '', precio = 0, editId = null) {
    console.log('Creando Ajuste #'+(noAjustes+1));
    // Title for row
    $(ajusteContainer).append('<h5>Ajuste #'+(noAjustes+1)+'</h5>');

    // Create row
    var row = document.createElement('div');
    row.className = 'row';
    row.id = 'ajuste'+noAjustes;

    // Create first DatePicker
    var col1 = document.createElement('div');
    col1.className = 'col-md-3';
    var titulo = '<p class="text-center">Fecha Promesa con Cliente</p>'

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", 'fechaClienteOculta[]');
    input.setAttribute("id", 'fechaClienteOculta'+noAjustes);
    input.setAttribute("value", fechaCliente ? fechaCliente : 'now');

    var datepicker1 = document.createElement('div');
    datepicker1.id = 'fechaCliente'+noAjustes;

    $(col1).append(titulo);
    // If it's an edit process create an input with the ID for the data
    if (editId) {
        var input2 = document.createElement("input");
        input2.setAttribute("type", "hidden");
        input2.setAttribute("name", 'editIdOculto[]');
        input2.setAttribute("value", editId);
        col1.appendChild(input2);
    }
    col1.appendChild(input);
    col1.appendChild(datepicker1);
    row.appendChild(col1);


    // Create Second DatePicker
    var col2 = document.createElement('div');
    col2.className = 'col-md-3';
    var titulo = '<p class="text-center">Fecha Promesa con Planta</p>'

    var datepicker2 = document.createElement('div');
    datepicker2.id = 'fechaPlanta'+noAjustes;

    var input = document.createElement("input");
    input.setAttribute("type", "hidden");
    input.setAttribute("name", 'fechaPlantaOculta[]');
    input.setAttribute("id", 'fechaPlantaOculta'+noAjustes);
    input.setAttribute("value", fechaPlanta ? fechaPlanta : 'now');

    $(col2).append(titulo);
    col2.appendChild(input);
    col2.appendChild(datepicker2);
    row.appendChild(col2);

    // Create 3rd column
    var col3 = document.createElement('div');
    col3.className = 'col-md-3';

    var inputs = '<div class="form-group label-floating">'+
                    '<label class="control-label">Número de Prendas</label>'+
                    '<input type="number" min="1" step="1" name="num_prendas[]" id="num_prendas'+noAjustes+'" class="form-control" value="'+noPrendas+'">'+
                '</div>'+
                '<div class="form-group label-floating">'+
                    '<label class="control-label">Tipo de Prenda</label>'+
                    '<input type="text" name="tipo_prenda[]" id="tipo_prenda'+noAjustes+'" class="form-control" value="'+tipoPrenda+'">'+
                '</div>'+
                '<div class="form-group label-floating">'+
                    '<label class="control-label">Precio del Ajuste</label>'+
                    '<input type="number" min="0" step="0.1" name="precio[]" id="precio'+noAjustes+'" class="form-control" value="'+precio+'">'+
                '</div>';

    $(col3).append(inputs);
    row.appendChild(col3);

    // Create 4th column
    var input = '<div class="col-md-3">'+
                    '<div class="form-group label-floating">'+
                        '<label class="control-label">Descripción del Ajuste</label>'+
                        '<textarea name="descripcion[]" id="descripcion'+noAjustes+'" cols="30" rows="10" class="form-control">'+descripcion+'</textarea>'+
                    '</div>'+
                    '<button type="button" id="eliminarAjuste'+noAjustes+'" class="btn btn-danger pull-right">Eliminar Ajuste #'+(noAjustes+1)+'</button>'+
                '</div>';

    $(row).append(input);
    // Append row
    ajusteContainer.appendChild(row);

    // Event Listener to delete row
    var botonEliminar = document.getElementById('eliminarAjuste'+noAjustes);
    var tempNoAjustes = noAjustes;

    botonEliminar.addEventListener('click', () => {
        if (confirm('¿Estás seguro/segura de eliminar el Ajuste #'+(tempNoAjustes+1)+'? Esta acción NO se puede deshacer.')) {
            $('#ajuste'+tempNoAjustes).remove();
            console.log('Eliminando Ajuste #'+tempNoAjustes);
        }
    });

    // Initialize datepickers
    $('#fechaCliente'+tempNoAjustes).datetimepicker({
        inline: true,
        format: 'MM/dd/YYYY',
        defaultDate: fechaCliente,
    }).on('dp.change', function() {
        console.log($(this).data('DateTimePicker').date().format());
        $('#fechaClienteOculta'+tempNoAjustes).val($(this).data('DateTimePicker').date().format());
        console.log($('#fechaClienteOculta'+tempNoAjustes).val());
    });

    $('#fechaPlanta'+tempNoAjustes).datetimepicker({
        inline: true,
        format: 'MM/dd/YYYY',
        defaultDate: fechaPlanta,
    }).on('dp.change', function() {
        $('#fechaPlantaOculta'+tempNoAjustes).val($(this).data('DateTimePicker').date().format());
    });

    // Increase counter
    noAjustes++;
}

// Bind button to create new rows
const botonAjuste = document.getElementById('botonajuste');

botonAjuste.addEventListener('click', () => {
    addAdjustment();
});
</script>
@hasSection('editId')
<script type="text/javascript">
    @foreach ($adjustmentOrder->adjustments as $ajuste)
        addAdjustment(
            '{{ $ajuste->promesa_cliente }}',
            '{{ $ajuste->promesa_planta }}',
            {{ $ajuste->num_prendas }},
            '{{ $ajuste->tipo_prenda }}',
            '{{ $ajuste->descripcion }}',
            '{{ $ajuste->precio }}',
            {{ $ajuste->id }}
        );
    @endforeach
</script>
@else
<script src="{{ asset('js/adjustments.js') }}"></script>
@endif

@endsection