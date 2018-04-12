/*
 * Adjustment Functionality
 *
 * This file handles all the logic behind the adjustments' create and edit forms.
 * Copyright International Sewing Company S.A. de C.V.
 */

// Require for Axios
require('./bootstrap');

// Generación de Ajuste
const ajusteContainer = document.getElementById('ajustes-container');
var noAjustes = 0;

function addAdjustment(fechaCliente = '', fechaPlanta = '', noPrendas = '', tipoPrenda = '', descripcion = '') {
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

// Prefill data
const endpoint = '/validador/op/';
const boton = document.getElementById('botonop');
const input = document.getElementById('consecutivo_op');

const consecutivoOp = document.getElementById('consecutivo_op2');
const cliente = document.getElementById('client_id');

function resetMainInput(refreshValue) {
	if (refreshValue) {
		input.value= '';
	}
	boton.classList.remove('disabled');
	boton.textContent = 'Buscar Orden de Producción';
}

// The event Listener
boton.addEventListener('click', () => {
	if (boton.classList.contains('disabled')) {
		return;
	}
	boton.classList.add('disabled');
	boton.textContent = "Cargando...";

	axios.get(endpoint+input.value)
		.then(response => {
			if (response.data.length > 0 ) {
				$.notify({
					icon: 'done',
					title: '¡Hurra!',
					message: 'Hemos localizado la orden #'+response.data[0].id+' que corresponde a la Orden de Producción proporcionada.',
				},{
					type: 'success'
				});
				boton.classList.remove('btn-info');
				boton.classList.add('btn-success');
				boton.classList.add('disabled');
				input.setAttribute('disabled','disabled');
				boton.textContent = '¡Orden Localizada!';
				// Set data on the Form
				consecutivoOp.value = input.value;
				cliente.value = response.data[0].client_id;

				$('input').trigger('change');
				$('select').trigger('change');

				// Coat, Vest and Pants
				if (response.data[0].has_coat) {
					addAdjustment('','',1,'Saco');
				}
				if (response.data[0].has_pants) {
					addAdjustment('','',1,'Pantalones');
				}
				if (response.data[0].has_vest) {
					addAdjustment('','',1,'Chaleco');
				}

			} else {
				$.notify({
					icon: 'warning',
					title: "¡Recórcholis!",
					message: 'No hemos podido localizar ningún pedido en el sistema que corresponda con la Orden de Producción proporcionada.',
				},{
					type: 'warning'
				});
				resetMainInput(false);
			}
		})
		.catch(function (error) {
			$.notify({
				icon: 'error',
				title: "¡Oh oh!",
				message: error,
			},{
				type: 'danger'
			});
			resetMainInput(true);
		});
});

