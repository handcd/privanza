@extends('admin.layout.main')

@section('content')
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
                <h4 class="title">Modificar tus datos</h4>
                <p class="category">Aquí puedes editar tu información si consideras que existe algún error.</p>
            </div>
            <div class="card-content">
                <form action="{{ url('/admin/perfil/') }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Nombre Completo:</label>
                                <input type="text" name="name" value="{{ $admin->name }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Correo Electrónico:</label>
                                <input type="email" name="email" value="{{ $admin->email }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/admin/perfil') }}" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-success pull-right">Actualizar Información</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection