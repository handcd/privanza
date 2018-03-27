@extends('validador.layout.main')

@section('content')
<script src="{{ asset('js/adjustments.js') }}"></script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Añadir Orden de Ajustes</h4>
                <p class="category">Formulario para registrar una nueva Orden de Ajustes nuevo en el sistema</p>
            </div>
            <div class="card-content">
                <form action="{{ url('/validador/ajustes') }}/@yield('editId')" method="post" onsubmit="return confirm('¿La información que deseas registrar es correcta?');">
                    {{ csrf_field() }}
                    @section('editMethod')
                        @show
                    
                    <h4>Datos Generales de la Orden</h4>


                    <button type="submit" class="btn btn-success pull-right">Confirmar</button>
                    <a href="{{ url('/vendedor/clientes') }}" class="btn btn-default">Cancelar</a>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection