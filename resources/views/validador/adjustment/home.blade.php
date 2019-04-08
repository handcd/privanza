@extends('validador.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/validador/ajustes/telas/agregar') }}"><i class="material-icons">add</i>Registrar una nueva tela</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todas las telas</h4>
                <p class="category">Listado de telas</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Color</th>
                        <th>Nombre</th>
                        <th>Composición</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($telas as $tela)
                        <tr>
                            <td> {{ $tela->id }} </td>
                            <td> {{ $tela->codigo_tela}} </td>
                            <td> {{ $tela->color_tela }} </td>
                            <td> {{ $tela->nombre_tela }} </td>
                            <td> {{ $tela->composicion }} </td>
                            <td> @if($tela->estado != Null)
                            		{{ $tela->estado }} 
                            	@else 
                            		Disponible
                            	@endif
                            </td>
                            <td class="td-actions text-right">                           
                                <a href="{{ url('/validador/ajustes/telas/'.$tela->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs"> <i class="material-icons">edit</i></a>     
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               <center> {{ $telas->links() }} </center>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/validador/ajustes/forros/agregar') }}"><i class="material-icons">add</i>Registrar un nuevo forro</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todos los forros</h4>
                <p class="category">Listado de forros</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Color</th>
                        <th>Nombre</th>
                        <th>Composición</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($forros as $forro)
                        <tr>
                            <td> {{ $forro->id }} </td>
                            <td> {{ $forro->codigo_tela}} </td>
                            <td> {{ $forro->color_tela }} </td>
                            <td> {{ $forro->nombre_tela }} </td>
                            <td> {{ $forro->composicion }} </td>
                            <td> @if($forro->estado != Null)
                                    {{ $forro->estado }} 
                                @else 
                                    Disponible
                                @endif
                            </td>
                            <td class="td-actions text-right">                           
                                <a href="{{ url('/validador/ajustes/forros/'.$forro->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs"> <i class="material-icons">edit</i></a>     
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               <center> {{ $forros->links() }} </center>
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