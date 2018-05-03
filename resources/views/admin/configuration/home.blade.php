@extends('admin.layout.main')

@section('content')
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
            <div class="card-header" data-background-color="green">
                <h4 class="title">Configuración del Sistema</h4>
                <p class="category">Aquí puedes modificar la configuración general del sistema.</p>
            </div>
            <div class="card-content">
                <form action="{{ url('/admin/configuracion') }}" method="POST" onsubmit="return confirm('¿Estás segur@ de actualizar la configuración? ¡Tus cambios tomarán efecto de inmediato!')">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    
                    <h4>Tiempos de Envío de Notificaciones sobre estado de órdenes:</h4>
                    <p>Estos tiempos se miden en <strong>horas</strong> y son el tiempo que debe pasar cuando una orden se encuentra en un determinado estado para que el sistema envíe un correo de recordatorio. Puedes colocar un 0 si deseas que <strong>no se notifique ante dicha acción.</strong></p>
                    <div class="row">
                    	<div class="col-md-4 col-md-offset-1">
                    		<div class="form-group">
                    			<label>Orden <strong>no aprobada</strong></label>
                    			<input type="number" name="horas_aviso_no_aprobada" min="0" step="1" value="{{ $configuration->horas_aviso_no_aprobada }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden <strong>aprobada</strong></label>
                    			<input type="number" name="horas_aviso_aprobada" min="0" step="1" value="{{ $configuration->horas_aviso_aprobada }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden en <strong>producción</strong></label>
                    			<input type="number" name="horas_aviso_produccion" min="0" step="1" value="{{ $configuration->horas_aviso_produccion }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden en <strong>producción - <i>corte</i></strong></label>
                    			<input type="number" name="horas_aviso_produccion_corte" min="0" step="1" value="{{ $configuration->horas_aviso_produccion_corte }}" class="form-control">
                    		</div>
                    	</div>
                    	<div class="col-md-4">
                    		<div class="form-group">
                    			<label>Orden en <strong>producción - <i>ensamble</i></strong></label>
                    			<input type="number" name="horas_aviso_produccion_ensamble" min="0" step="1" value="{{ $configuration->horas_aviso_produccion_ensamble }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden en <strong>producción - <i>plancha</i></strong></label>
                    			<input type="number" name="horas_aviso_produccion_plancha" min="0" step="1" value="{{ $configuration->horas_aviso_produccion_plancha }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden en <strong>producción - <i>revisión</i></strong></label>
                    			<input type="number" name="horas_aviso_produccion_revision" min="0" step="1" value="{{ $configuration->horas_aviso_produccion_revision }}" class="form-control">
                    		</div>
                    		<div class="form-group">
                    			<label>Orden <strong>lista para recolección</strong></label>
                    			<input type="number" name="horas_aviso_pickup" min="0" step="1" value="{{ $configuration->horas_aviso_pickup }}" class="form-control">
                    		</div>
                    	</div>
                    </div>

                	<h4>Notificaciones</h4>
                	<p>Estas son todas las notificaciones (correos electrónicos) disponibles para enviar desde el sistema cada que se ejecuta alguna acción. Puedes activar/desactivar según sea conveniente</p>
                	<div class="row">
                		<div class="col-md-4">
                			<h4>Administrador</h4>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nueva_orden"
									@if ($configuration->notificar_admin_nueva_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Orden
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_orden"
									@if ($configuration->notificar_admin_cambio_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Orden Modificada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nueva_cita"
									@if ($configuration->notificar_admin_nueva_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_cita"
									@if ($configuration->notificar_admin_cambio_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en alguna Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nuevo_ajuste"
									@if ($configuration->notificar_admin_nuevo_ajuste)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Ajuste
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_ajuste"
									@if ($configuration->notificar_admin_cambio_ajuste)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Ajuste
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nuevo_vendedor"
									@if ($configuration->notificar_admin_nuevo_vendedor)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Vendedor
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_vendedor"
									@if ($configuration->notificar_admin_cambio_vendedor)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Vendedor
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nuevo_validador"
									@if ($configuration->notificar_admin_nuevo_validador)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Validador
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_validador"
									@if ($configuration->notificar_admin_cambio_validador)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambio en Validador
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_nuevo_cliente"
									@if ($configuration->notificar_admin_nuevo_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_cambio_cliente"
									@if ($configuration->notificar_admin_cambio_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_aprobada"
									@if ($configuration->notificar_admin_orden_aprobada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea Aprobada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_produccion"
									@if ($configuration->notificar_admin_orden_produccion)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden entre a Producción
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_produccion_corte"
									@if ($configuration->notificar_admin_orden_produccion_corte)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Corte
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_produccion_ensamble"
									@if ($configuration->notificar_admin_orden_produccion_ensamble)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Ensamble
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_produccion_plancha"
									@if ($configuration->notificar_admin_orden_produccion_plancha)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Plancha
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_produccion_revision"
									@if ($configuration->notificar_admin_orden_produccion_revision)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Revisión
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_pickup"
									@if ($configuration->notificar_admin_orden_pickup)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden esté lista para Recolección
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_entregada"
									@if ($configuration->notificar_admin_orden_entregada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Entregada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_cobrada"
									@if ($configuration->notificar_admin_orden_cobrada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Cobrada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_orden_facturada"
									@if ($configuration->notificar_admin_orden_facturada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Facturada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_vendedor_activado"
									@if ($configuration->notificar_admin_vendedor_activado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Vendedor sea Activada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_vendedor_desactivado"
									@if ($configuration->notificar_admin_vendedor_desactivado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Vendedor sea Desactivada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_validador_activado"
									@if ($configuration->notificar_admin_validador_activado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Validador sea Activada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_admin_validador_desactivado"
									@if ($configuration->notificar_admin_validador_desactivado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Validador sea Desactivada
							</div>
                		</div>
                		<div class="col-md-4">
                			<h4>Validador</h4>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_nueva_orden"
									@if ($configuration->notificar_validador_nueva_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Orden
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_orden"
									@if ($configuration->notificar_validador_cambio_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Orden Modificada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_nueva_cita"
									@if ($configuration->notificar_validador_nueva_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_cita"
									@if ($configuration->notificar_validador_cambio_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en alguna Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_nuevo_ajuste"
									@if ($configuration->notificar_validador_nuevo_ajuste)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Ajuste
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_ajuste"
									@if ($configuration->notificar_validador_cambio_ajuste)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Ajuste
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_nuevo_vendedor"
									@if ($configuration->notificar_validador_nuevo_vendedor)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Vendedor
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_vendedor"
									@if ($configuration->notificar_validador_cambio_vendedor)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Vendedor
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_validador"
									@if ($configuration->notificar_validador_cambio_validador)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios de Información en Validador
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_nuevo_cliente"
									@if ($configuration->notificar_validador_nuevo_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_cambio_cliente"
									@if ($configuration->notificar_validador_cambio_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_aprobada"
									@if ($configuration->notificar_validador_orden_aprobada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea Aprobada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_produccion"
									@if ($configuration->notificar_validador_orden_produccion)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden entre a Producción
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_produccion_corte"
									@if ($configuration->notificar_validador_orden_produccion_corte)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Corte
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_produccion_ensamble"
									@if ($configuration->notificar_validador_orden_produccion_ensamble)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Ensamble
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_produccion_plancha"
									@if ($configuration->notificar_validador_orden_produccion_plancha)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Plancha
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_produccion_revision"
									@if ($configuration->notificar_validador_orden_produccion_revision)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden pase a Revisión
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_pickup"
									@if ($configuration->notificar_validador_orden_pickup)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden esté lista para Recolección
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_entregada"
									@if ($configuration->notificar_validador_orden_entregada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Entregada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_cobrada"
									@if ($configuration->notificar_validador_orden_cobrada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Cobrada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_orden_facturada"
									@if ($configuration->notificar_validador_orden_facturada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden haya sido Facturada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_desactivado"
									@if ($configuration->notificar_validador_desactivado)
										checked="true" 
									@endif
									>
								</label>
								Notificar al Validador si su cuenta se encuentra desactivada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_activado"
									@if ($configuration->notificar_validador_activado)
										checked="true" 
									@endif
									>
								</label>
								Notificar al Validador si su cuenta ha sido reactivada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_vendedor_activado"
									@if ($configuration->notificar_validador_vendedor_activado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Vendedor sea Activada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_validador_vendedor_desactivado"
									@if ($configuration->notificar_validador_vendedor_desactivado)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la cuenta de un Vendedor sea Desactivada
							</div>
                		</div>
                		<div class="col-md-4">
                			<h4>Vendedor</h4>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_nueva_orden"
									@if ($configuration->notificar_vendedor_nueva_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Orden
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_cambio_orden"
									@if ($configuration->notificar_vendedor_cambio_orden)
										checked="true" 
									@endif
									>
								</label>
								Notificar Orden Modificada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_nueva_cita"
									@if ($configuration->notificar_vendedor_nueva_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nueva Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_cambio_cita"
									@if ($configuration->notificar_vendedor_cambio_cita)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en alguna Cita
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_cambio_vendedor"
									@if ($configuration->notificar_vendedor_cambio_vendedor)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en información Vendedor
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_nuevo_cliente"
									@if ($configuration->notificar_vendedor_nuevo_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Nuevo Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_cambio_cliente"
									@if ($configuration->notificar_vendedor_cambio_cliente)
										checked="true" 
									@endif
									>
								</label>
								Notificar Cambios en algún Cliente
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_aprobada"
									@if ($configuration->notificar_vendedor_orden_aprobada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea Aprobada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_produccion"
									@if ($configuration->notificar_vendedor_orden_produccion)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden entre a Producción
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_pickup"
									@if ($configuration->notificar_vendedor_orden_pickup)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden esté lista para ser recogida
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_entregada"
									@if ($configuration->notificar_vendedor_orden_entregada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea entregada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_cobrada"
									@if ($configuration->notificar_vendedor_orden_cobrada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea Cobrada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_orden_facturada"
									@if ($configuration->notificar_vendedor_orden_facturada)
										checked="true" 
									@endif
									>
								</label>
								Notificar cuando la Orden sea Facturada
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_desactivado"
									@if ($configuration->notificar_vendedor_desactivado)
										checked="true" 
									@endif
									>
								</label>
								Notificar al Vendedor si su cuenta se desactiva
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="notificar_vendedor_activado"
									@if ($configuration->notificar_vendedor_activado)
										checked="true" 
									@endif
									>
								</label>
								Notificar al Vendedor si su cuenta se activa
							</div>
                		</div>
                	</div>
                	<p class="pull-left">Esta configuración fue actualizada por última vez el: <strong>{{ $configuration->updated_at }}</strong></p>
                    <button type="submit" class="btn btn-danger pull-right">Actualizar Configuración</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection