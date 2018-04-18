@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/admin/validadores/agregar') }}"><i class="material-icons">add</i>Añadir nuevo Validador</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todos los validadores</h4>
                <p class="category">Todos los validadores registrados en el sistema</p>
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
                        @forelse ($validadores as $validador)
                        <tr>
                            <td>{{ $validador->id }}</td>
                            <td>{{ $validador->name }}</td>
                            <td><a href="mailto:{{$validador->email}}">{{ $validador->email }}</a></td>
                            <td>{{ $validador->enabled ? 'Activo' : 'Inactivo' }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/admin/validadores/'.$validador->id) }}" type="button" rel="tooltip" title="Ver Validador" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/admin/validadores/'.$validador->id.'/editar') }}" type="button" rel="tooltip" title="Editar Validador" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay validadores registrados aún :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $validadores->links() }}
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