@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">{{ $admin->name }}</h4>
                <p class="category">Estos son tus datos, verifica que sean correctos o edítalos de ser necesario.</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Nombre Completo</label>
                        <p>{{ $admin->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Correo Electrónico</label>
                        <p><a href="mailto:{{ $admin->email }}">{{ $admin->email }}</a></p>
                    </div>
                </div>
                <a href="{{ url('/admin/perfil/editar') }}" class="btn btn-success pull-right">Editar Información</a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection