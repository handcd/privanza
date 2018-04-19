@extends('admin.layout.main')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Orden de Ajustes {{ $adjustmentOrder->consecutivo_ajuste }}</h4>
                <p class="category">Detalles de la Orden de Ajustes #{{ $adjustmentOrder->id }}</p>
            </div>
            <div class="card-content">
            	<h3>Información General de Orden</h3>
            	<div class="row">
            		<div class="col-md-3">
            			<label class="text-primary">ID de Orden</label>
            			<p>{{ $adjustmentOrder->id }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Consecutivo de Ajuste</label>
            			<p>{{ $adjustmentOrder->consecutivo_ajuste }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Consecutivo de Orden de Producción</label>
            			<p>{{ $adjustmentOrder->consecutivo_op }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Status Actual</label>
            			<p>
            				@switch($adjustmentOrder->status)
            				    @case(0)
            				        Sin Aprobar
            				        @break
            					@case(1)
            						Aprobada (En Producción)
            						@break
            				    @default
            				        Finalizada
            				@endswitch
            			</p>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-3">
            			<label class="text-primary">Fecha de Creación de Orden</label>
            			<p>{{ $adjustmentOrder->created_at }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Fecha de Modificación</label>
            			<p>{{ $adjustmentOrder->updated_at }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Precio General Calculado</label>
            			<p>${{ $adjustmentOrder->adjustments->sum('precio') }} MXN</p>
            		</div>
            	</div>
            	<h3>Ajustes de la Orden</h3>
            	@foreach ($adjustmentOrder->adjustments as $ajuste)
            	<h5>Ajuste #{{ $loop->iteration }}</h5>
            	<div class="row">
            		<div class="col-md-2">
            			<label class="text-primary">ID Único de Ajuste</label>
            			<p>{{ $ajuste->id }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Fecha de Promesa en Planta</label>
            			<p>{{ $ajuste->promesa_planta }}</p>
            		</div>
            		<div class="col-md-3">
            			<label class="text-primary">Fecha de Promesa con Cliente</label>
            			<p>{{ $ajuste->promesa_cliente }}</p>
            		</div>
            		<div class="col-md-2">
            			<label class="text-primary">Precio</label>
            			<p>${{ $ajuste->precio }} MXN</p>
            		</div>
            		<div class="col-md-2">
            			<label class="text-primary">Número de Prendas</label>
            			<p>{{ $ajuste->num_prendas }}</p>
            		</div>
            	</div>
            	<div class="row">
            		<div class="col-md-2">
            			<label class="text-primary">Tipo de Prenda</label>
            			<p>{{ $ajuste->tipo_prenda }}</p>
            		</div>
            		<div class="col-md-4">
            			<label class="text-primary">Descripción de Ajuste</label>
            			<p>{{ $ajuste->descripcion }}</p>
            		</div>
            	</div>
            	@endforeach
            </div>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<a href="{{ url('/admin/ajustes') }}" class="btn btn-info">Regresar</a>
	</div>
</div>
@endsection