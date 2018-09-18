<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Privanza | Detalles de Pedido #{{ $orden->id }}</title>

    <!-- Styles -->
     <style>
        /* Estilos custom para PDF */
        body {
            background: none !important;
        }
        h1, h2, h3, h4, h5, h6, p {
            font-family: "Helvetica";
        }
        td {
            font-family: "Helvetica";
            font-size: 5;
        }
        tbody:before, tbody:after { display: none; }
    </style> 
</head>
<body>
    <div class="row">
        <div class="col-md-10 text-center">
            <h3>Privanza | Detalle de Orden #{{ $orden->id }} </h3>
        </div>
    </div>
    {{-- Detalles Generales de la orden --}}
    <table class="table table-bordered">
        <thead>
            <tr>
              <td scope="col">Fecha de elaboración: {{ Carbon\Carbon::now() }}</td>
              <td scope="col">Vendedor: {{ $orden->vendedor->name }}</td>
              <td scope="col">Cliente: {{ $orden->client->name}} {{$orden->client->lastname }}</td>
            </tr>
        </thead>
    </table> 
    {{-- Especificaciones --}}         
    <h3>Especificaciones:</h3>
    
    {{-- Saco --}}
    @if($orden->has_coat)
        <div class="row">
            <div class="col-xs-12">
                <b>Saco</b>
            </div>
        </div>
        <table class="table table-bordered">    
            <tr>
                <td>
                    Fit Deseado:
                    <br>
                    @if($saco->fit_id)
                        {{ $saco->fit->name}}
                    @else
                        Desconocido
                    @endif    
                </td>
                <td>
                    Largo de Manga deseado:
                    <br>
                    {{ $saco->talla}} pulgadas
                </td>
                <td>
                    Tipo de solapa: 
                    <br>
                    @switch( $saco->tipo_solapa)
                        @case(0)
                                En pico normal
                            @break
                        @case(1)
                                En pico ancha
                            @break
                        @case(2)
                                En escuadra normal
                            @break
                        @case(3)
                                En escuadra ancha
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Color de ojal en solapa:
                    <br>
                    @if( $saco->tipo_ojal_solapa === 2) 
                        En Contraste. Color {{ $saco->color_ojal_solapa}}.
                    @else
                        Al tono
                    @endif
                </td>
                <td>
                    Ojal Activo en solapa:
                    <br>
                     @if( $saco->ojal_activo_solapa === 1) 
                        Sí
                    @else
                        No
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Color de ojal en manga:
                    <br>
                    @if( $saco->tipo_ojal_manga === 2) 
                        En Contraste. Color {{ $saco->color_ojal_manga}}.
                    @else
                        Al tono
                    @endif
                </td>
                <td>
                    Ojal Activo en manga:
                    <br>
                     @if( $saco->ojal_activo_manga === 1) 
                        Sí. Posición de ojales: {{ $saco->posicion_ojales_activos_manga}} 
                    @else
                        No
                    @endif
                </td>
                <td>
                    Número de botones:
                    <br>
                    @switch( $saco->botones_frente)
                        @case(1)
                                1 botón
                            @break
                        @case(2)
                                2 botones
                            @break
                        @case(3)
                                3 botones
                            @break
                        @case(6)
                                6 botones
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Número de aberturas traseras:
                    <br>
                     @switch( $saco->aberturas_detras)
                        @case(0)
                                Sin aberturas
                            @break
                        @case(1)
                                Una abertura
                            @break
                        @case(2)
                                Dos aberturas
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Número de botones en mangas:
                    <br>
                    @switch( $saco->botones_mangas)
                        @case(1)
                                Un botón
                            @break
                        @case(2)
                                Dos botones
                            @break
                        @case(3)
                                Tres botones
                            @break
                        @case(4)
                                Cuatro botones
                            @break    
                        @default
                            Desconocido
                    @endswitch
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
        </table>    
    @endif
    {{--
    <div class="col-xs-2">
            <p>
                
                {{ }}
            </p>
        </div> --}}
    {{--Fin Saco --}}
    {{-- Chaleco --}}
    @if($orden->has_vest)
        <div class="row">
        <div class="col-xs-12">
            <b>Chaleco</b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-1">
            <p> 
            Fit Deseado:
            @if($chaleco->fit_id)
                {{ $chaleco->fit->name}}
            @else
                Desconocido
            @endif                                   
            </p>    
        </div>
    </div>
    @endif
    {{-- Fin Chaleco --}}
    {{-- Pantalón --}}
    @if($orden->has_pants)
        <div class="row">
        <div class="col-xs-12">
            <b>Pantalón</b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-1">
            <p> 
            Fit Deseado:
            @if($pantalon->fit_id)
                {{ $pantalon->fit->name}}
            @else
                Desconocido
            @endif                                   
            </p>
        </div>
    </div>
    @endif
    {{--Fin Pantalón --}}
    
</body>
</html>