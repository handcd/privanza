@extends('admin.layout.main')

@section('content')
<div class="row">
    <div class="col-md-12" style="float: right;">
        <a class="btn btn-success btn-large" href="{{ url('/admin/forros/agregar') }}"><i class="material-icons">add</i>Registrar un nuevo forro</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Todas las forros</h4>
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
                            <td> {{ $forro->codigo_forro}} </td>
                            <td> {{ $forro->color_forro }} </td>
                            <td> {{ $forro->nombre_forro }} </td>
                            <td> {{ $forro->composicion }} </td>
                            <td> @if($forro->estado != Null)
                                    {{ $forro->estado }} 
                                @else 
                                    Disponible
                                @endif
                            </td>
                            <td class="td-actions text-right">                           
                                <a href="{{ url('/admin/forros/'.$forro->id.'/editar') }}" type="button" rel="tooltip" title="Editar Orden" class="btn btn-primary btn-simple btn-xs"> <i class="material-icons">edit</i></a>  
                                <form action="{{'/admin/forros/'.$forro->id.'/eliminar'}}" method="post">
                                  {{csrf_field()}}
                                    {{ method_field('DELETE') }}
                                      <button type="submit" style="background-color: transparent !important; border: none; color: red;">
                                        <i class="material-icons">delete</i> 
                                      </button> 
                                </form>       
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