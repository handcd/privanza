@extends('vendedor.layout.main')

@section('content')

{{--	<form action="{{ url('/admin/ordenes/'.$orden->id.'/editar') }}">
    	Precio
        <div class="input-group">
            <input name="precio" type="text" class="form-control" value="{{$orden->precio}}">        
        </div>
        <div class="col-md-3">
        	<input type='submit' class='btn btn-finish btn-fill btn-success'/>
        </div>

        <div class="input-group">
            <input name="consecutivo_op" type="text" class="form-control">        
        </div>

        <br><br><br>
	</form> 
	@section('content')--}}
<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
<!-- DateTimePicker JS -->
<script src="{{ asset('js/datepicker.js') }}"></script>
<div class="row">
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
            <h4 class="title">Añadir precio y consecutivo de operación a una orden</h4>
            <p class="category">Completa la información</p>
        </div>
        <div class="card-content">
            <form action="{{ url('/vendedor/ordenes/'.$orden->id) }}" method="POST">
                {{ csrf_field() }}
                    <br><br><br>
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-3 col-md-offset-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Precio</label>
                            <input name="precio" type="number" class="form-control" value="{{$orden->precio}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group label-floating">
                            <label class="control-label">Consecutivo de operación</label>
                            <input type="text" name="consecutivo_op" class="form-control" value="{{$orden->consecutivo_op}}">
                        </div>
                    </div>
                    <div clasv>
                    </div>
                </div>               
                
                <button type="submit" class="btn btn-success pull-right">Guardar</button>
                <a href="{{ url('/vendedor/ordenes') }}" class="btn btn-default">Cancelar</a>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>  
@endsection                  


 
