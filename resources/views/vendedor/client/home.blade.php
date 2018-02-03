@extends('vendedor.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/vendedor/clientes/agregar') }}"><i class="material-icons">add</i>Añadir nuevo cliente</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todos los clientes</h4>
                <p class="category">Lista general de clientes registrados en el sistema</p>
            </div>
            <div class="card-content table-responsive">
                <div class="col-md-6">
                    <input id="filter" class="form-control" type="text" placeholder="Buscar Cliente...">
                </div>
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>Nombre(s)</th>
                        <th>Apellido(s)</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody class="searchable">
                        @forelse ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->name }}</td>
                            <td>{{ $cliente->lastname }}</td>
                            <td><a href="mailto:{{$cliente->email}}">{{ $cliente->email }}</a></td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/clientes/'.$cliente->id) }}" type="button" rel="tooltip" title="Ver Cliente" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                                 <a href="{{ url('/vendedor/clientes/'.$cliente->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cliente" class="btn btn-primary btn-simple btn-xs">
                                    <i class="material-icons">edit</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="5">No tienes clientes registrados :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="row text-center">
                    {{ $clientes->links() }}
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