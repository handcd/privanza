/*
 * Adjustment Functionality
 *
 * This section contains all the logic behind prefilling the data needed to 
 * fill an Adjustment Order based on a previous existing order using its
 * production order number (which, in theory, is unique).
 * This implementation uses Axios.
 */

// Require for Axios
require('./bootstrap');

const server = process.env.MIX_APP_URL;
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

	console.log('URL endpoint: '+server+endpoint+input.value);
	
	axios.get(server+endpoint+input.value)
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

