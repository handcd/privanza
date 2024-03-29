@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/admin/vendedores/agregar') }}"><i class="material-icons">add</i>Añadir nuevo vendedor</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todos los vendedores</h4>
                <p class="category">Todos los vendedores registrados en el sistema</p>
            </div>
            <div class="card-content table-responsive">
                <div class="col-md-6">
                    <input id="filter" class="form-control" type="text" placeholder="Buscar Vendedor...">
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Activo/Inactivo</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody class="searchable">
                        @forelse ($vendedores as $vendedor)
                        <tr>
                            <td>{{ $vendedor->id }}</td>
                            <td>{{ $vendedor->name }}</td>
                            <td><a href="mailto:{{$vendedor->email}}">{{ $vendedor->email }}</a></td>
                            <td>{{ $vendedor->enabled ? 'Activo' : 'Inactivo' }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/vendedores/'.$vendedor->id) }}" type="button" rel="tooltip" title="Ver Vendedor" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/vendedores/'.$vendedor->id.'/editar') }}" type="button" rel="tooltip" title="Editar Vendedor" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay vendedores registrados aún :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $vendedores->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#filter').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.searchable tr').hide();
                $('.searchable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        })(jQuery);
    });
</script>
@endsection