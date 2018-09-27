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
            font-size: 6;
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
              <td> Teléfono del cliente: {{ $orden->client->phone}}</td>
              <td>Correo eléctronico del cliente: {{ $orden->client->email}}</td>
            </tr>
        </thead>
    </table> 
    <h4>Medidas Corporales:</h4>
    <table class="table table-bordered">
        <tr>
            <td>
            Altura:
            <br>
            @if($orden->client->altura)                
                {{ $orden->client->altura  }} Cm.
            @else
                Desconocido
            @endif
            </td>
            <td>
            Peso:
            <br>
            @if($orden->client->peso)
                {{ $orden->client->peso  }} Kg.
            @else
                Desconocido
            @endif
            </td>
            <td>
            Edad:
            <br>
            @if($orden->client->edad)
                {{ $orden->client->edad  }} años
            @else
                Desconocido
            @endif
            </td>
            <td>
            Abdomen:
            <br>
            @if($orden->client->abdomen)
                 @switch( $orden->client->abdomen )
                    @case(0)
                          <p>Delgado</p>
                          @break
                    @case(1)
                          <p>Normal</p>
                          @break
                    @case(2)
                          <p>Voluminoso</p>
                          @break
                    @default
                          <p>Entrada inválida</p>
                @endswitch
            @else
                Desconocido
            @endif
            </td>
            <td>
            Pecho:
            <br>
            @if($orden->client->pecho)
                @switch( $orden->client->pecho )
                    @case(0)
                            <p>Musculoso</p>
                            @break
                    @case(1)
                            <p>Normal</p>
                            @break
                    @case(2)
                            <p>Curpulento</p>
                            @break
                    @default
                            <p>Entrada inválida</p>
                @endswitch 
            @else
                Desconocido
            @endif
            </td>
            <td>
            Espalda:
            <br>
            @if($orden->client->espalda)
                @switch( $orden->client->esplada )
                    @case(0)
                        <p>Recta</p>
                        @break
                    @case(1)
                        <p>Normal</p>
                        @break
                    @case(2)
                        <p>Encorvada</p>
                        @break
                    @default
                        <p>Entrada inválida</p>
                @endswitch
            @else
                Desconocido
            @endif
            </td>
            <td>
            Tipo de hombros:
            <br>
            @if($orden->client->hombros === 0 )
                Rectos
            @else
                Normales
            @endif
            </td>
            <td>
            Contorno de cuello:
            <br>
            @if($orden->client->contornoCuello)
                {{ $orden->client->contornoCuello  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
            Contorno de biceps:
            <br>
            @if($orden->client->contornoBiceps)
                {{ $orden->client->contornoBiceps  }} pulgadas 
            @else
                Desconocido
            @endif
            </td>
            <td>
            Medida de hombros:
            <br>
            @if($orden->client->medidaHombros)
                {{ $orden->client->medidaHombros  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
        </tr>
        <tr>
            <td>
            Medida brazo derecho:
            <br>
            @if($orden->client->brazoDerecho)
                {{ $orden->client->brazoDerecho  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
            Medida brazo izquierdo:
            <br>
            @if($orden->client->brazoIzquierdo)
                {{ $orden->client->brazoIzquierdo  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
            Medida hombro derecho:
            <br>
            @if($orden->client->hombroDerecho)
                {{ $orden->client->hombroDerecho  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
            Medida hombro izquierdo:
            <br>
            @if($orden->client->hombroIzquierdo)
                {{ $orden->client->hombroIzquierdo  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
            Ancho espalda:
            <br>
            @if($orden->client->anchoEspalda)
                {{ $orden->client->anchoEspalda  }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Largo de torso:
                <br>
            @if($orden->client->largoTorso)
                {{ $orden->client->largoTorso }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Contorno de pecho:
                <br>
            @if($orden->client->contornoPecho)
                {{ $orden->client->contornoPecho }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Contorno de puño:
                <br>
            @if($orden->client->punio)
                {{ $orden->client->punio }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Contorno de abdomen:
                <br>
            @if($orden->client->contornoAbdomen)
                {{ $orden->client->contornoAbdomen }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Contorno de cintura:
                <br>
            @if($orden->client->contornoCintura)
                {{ $orden->client->contornoCintura }} pulgadas
            @else
                Desconocido
            @endif
            </td>
        </tr>
        <tr>
            <td>
                Contorno de cadera:
                <br>
                @if($orden->client->contornoCadera)
                    {{ $orden->client->contornoCadera  }} pulgadas
                @else
                    Desconocido
                @endif
            </td>
            <td>
                Largo de tiro:
                <br>
                @if($orden->client->largoTiro)
                    {{ $orden->client->largoTiro }} pulgadas
                @else
                    Desconocido
                @endif
            </td>
            <td>
                Largo interno de pantalón:
                <br>
            @if($orden->client->largoInternoPantalon)
                {{ $orden->client->largoInternoPantalon }} pulgadas
            @else
                Desconocido
            @endif
            </td>
            <td>
                Largo externo de pantalón:
                <br>
                @if($orden->client->largoExternoPantalon )
                    {{ $orden->client->largoExternoPantalon }} pulgadas
                @else
                    Desconocido
                @endif
            </td>
            <td>
                Contorno de muslo:
                <br>
                @if( $orden->client->contornoMuslo)
                    {{ $orden->client->contornoMuslo }} pulgadas
                @else
                    Desconocido
                @endif
            </td>
            <td>
                Contorno de Rodilla:
                <br>
                @if( $orden->client->contornoRodilla )
                    {{ $orden->client->contornoRodilla }} pulgadas
                @else
                    Desconocido
                @endif
            </td>
            {{--<td>
                
                <br>
                @if( $orden->client-> )
                    {{ $orden->client-> }} 
                @else
                    Desconocido
                @endif
            </td>--}}
        </tr>
        
    </table>
    {{-- Especificaciones --}}         
    <h4>Especificaciones:</h4>
    
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
                    @if($saco->talla) 
                        {{ $saco->talla }} pulgadas
                    @else
                        Desconocido
                    @endif
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
                <td>
                    Color de ojal en manga: 
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
            </tr>
            <tr>                
                <td>
                    No. de botones en mangas:
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
                <td>
                    Posición de botones en mangas:
                    <br>
                    @switch($saco->posicion_ojal_manga)
                        @case(0)
                            Botones en cascada
                            @break
                        @case(1)
                            Botones en línea
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Bolsas externas:
                    <br>
                    @switch($saco->tipo_bolsas_ext)
                        @case(0)
                            Parche
                            @break
                        @case(1)
                            Cartera
                            @break
                        @case(2)
                            Cartera en diagonal
                            @break
                        @case(3)
                            Vivo (sin cartera)
                            @break
                        @case(4)
                            Vivo Diagonal
                            @break
                        @case(5)
                            Cartera continental
                            @break
                        @case(6)
                            Cartera diagonal
                            @break
                        @case(7)
                            Sin bolsas
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Pick stitch:
                    <br>
                    @if( $saco->pickstitch === 1 )
                        Sí
                    @else
                        No
                    @endif
                </td>
                <td>
                    Aletillas:
                    <br>
                    @if( $saco->sin_aletilla === 1 )
                        Sin aletillas
                    @else
                        Con aletillas
                    @endif
                </td>
                <td>
                    Tipo de vista interna:
                    <br>
                    @if( $saco->tipo_vista === 0 )
                        Normal
                    @elseif( $saco->tipo_vista === 1 )
                        Chapeta Francesa
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Forro interno de mangas:
                    <br>
                    @if( $saco->balsam_rayas === 1 )
                        Balsam a Rayas
                    @else
                        {{ $saco->forro_interno_mangas}}
                    @endif
                </td>
                <td>
                    Accesorios: 
                    <br>
                    @if( $saco->tipoAccesorio == 0)
                        PinPoint. Color {{ $saco->accesorio_color }}
                    @elseif( $saco->tipoAccesorio == 1)
                        Bies. Color {{ $saco->accesorio_color}}
                    @else
                        Pinpoint y bies {{ $saco->accesorio_color}}
                    @endif

                </td>                   
                @if( $saco->bolsas_int )
                    <td>
                    Bolsas internas:
                    @switch( $saco->bolsas_int)
                        @case(1) 2 bolsas en pecho, 1 p/pluma, 1 p/cigarrera 
                            @break
                        @case(2) 2 bolsas en pecho, 1 p/pluma
                            @break
                        @case(3) 2 bolsas en pecho, 1 p/cigarrera
                            @break 
                        @case(4) 2 bolsas en pecho
                            @break
                        @default Desconocido
                    @endswitch
                    </td>
                @endif               
            </tr>
           
        </table> 
        <table class="table table-bordered">
             <tr>
                @if( $saco->vivos_bolsas_internas_cuerpo)
                    <td>
                        Vivos en bolsas internas:
                        <br>
                        Del mismo forro en cuerpo
                    </td>
                @elseif( $saco->otro_vivos_bolsas_internas)
                    <td>
                        Vivos en bolsas internas:
                        <br>
                        {{ $saco->otro_vivos_bolsas_internas }}
                    </td>
                @endif
                @if( $saco->notas_int)
                    <td>
                        Notas de saco interno:
                        <br>
                            {{ $saco->notas_int }}
                    </td>
                @endif
                @if( $saco->notas_ext)
                    <td>
                        Notas de saco externo:
                        <br>
                            {{ $saco->notas_ext }}
                    </td>
                @endif
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
        <table class="table table-bordered">
            <tr>
                <td>
                    Fit Deseado:
                    <br>
                    @if($chaleco->fit_id)
                        {{ $chaleco->fit->name}}
                    @else
                        Desconocido
                    @endif    
                </td>
                <td>
                    Largo de espalda deseado:
                    <br>
                    @if($chaleco->talla) 
                        {{ $chaleco->talla }} pulgadas
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Tipo de cuello:
                    <br>
                    @if( $chaleco->tipo_cuello === 1 )
                        Cuello en 'V'
                    @elseif( $chaleco->tipo_cuello === 2 )
                        Con solapa
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Bolsas delanteras:
                    <br>
                    @if( $chaleco->tipo_bolsas === 0 )
                        Vivo
                    @elseif( $chaleco->tipo_bolsas === 1 )
                        Con aletillas
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Forro o tela:
                    <br>
                    @if( $chaleco->tipo_espalda === 2 )
                        Tela
                    @elseif( $chaleco->tipo_espalda === 1 )
                        Forro. {{ $chaleco->tipo_forro}}
                    @else
                        Desconocido
                    @endif
                </td>
                @if( $chaleco->notas )
                    <td>
                        Notas: {{ $chaleco->notas}}
                    </td>
                @endif
            </tr>
        </table>
    @endif
    {{-- Fin Chaleco --}}
    {{-- Pantalón --}}
    @if($orden->has_pants)
        <div class="row">
            <div class="col-xs-12">
                <b>Pantalón</b>
            </div>
        </div>
        <table class="table table-bordered">
            <tr>
                <td>
                    Fit Deseado:
                    <br>
                    @if($pantalon->fit_id)
                        {{ $pantalon->fit->name }}
                    @else
                        Desconocido
                    @endif    
                </td>
                <td>
                    Talla de pantalón:
                    <br>
                    @if($pantalon->talla) 
                        {{ $pantalon->talla }} pulgadas
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Tipo de pase:
                    <br>
                    Con pase
                </td>
                <td>
                    Número de pliegues:
                    <br>
                    @if( $pantalon->pliegues === 0 )
                        Sin pliegues
                    @elseif( $pantalon->pliegues === 1 )
                        Un pliegue
                    @elseif( $pantalon->pliegues === 2)
                        Dos pliegues
                    @else
                        Desconocido
                    @endif
                </td>
                <td>
                    Bolsas traseras:
                    <br>
                    Dos bolsas traseras, vivo sencillo con ojal.                    
                </td>
                <td>
                    Color de bies, ojalera, encuarte y pretina:
                    <br>
                    {{ $pantalon->color_ojalera }}
                </td>
                <td>
                    Medio forro interior:
                    <br>
                    @if( $pantalon->medio_forro_piernas_al_tono )
                        Al tono
                    @else
                        {{ $pantalon->codigo_otro_color_medio_forro }} {{ $pantalon->otro_color_medio_forro}}
                    @endif
                </td>
            </tr>
        </table>
        <table class="table table-bordered">
            <tr>
                <td>
                    Dobladillo:
                    <br>
                    @switch( $pantalon->dobladillo)
                        @case(1)
                            Normal
                            @break
                        @case(2)
                            Valenciana
                            @break
                        @default
                            Desconocido
                    @endswitch
                </td>
                <td>
                    Notas:
                    <br>
                    {{ $pantalon->notas }}
                </td>
            </tr>
        </table>
    @endif
    {{--Fin Pantalón --}}
    {{-- Cuadros --}}
    <table class="table table-bordered">
        <tr>
            <td style="height: 50">
                <br><br><br><br><br>
                Testigo de tela:
            </td>
            <td>
                <br><br><br><br><br>
                Testigo de forro en cuerpo:
            </td>
            <td>
                <br><br><br><br><br>
                Testigo de forro en mangas:
            </td>
            <td>
                <br><br><br><br><br>
                Testigo de forro en vivos de bolsas internas:
            </td>
        </tr>
    </table>
    <table class="table table-bordered">
        <tr>
            <td style="height: 50">
                <br><br><br><br><br>
                Elaboro (original)
            </td>
            <td>
                <br><br><br><br><br>
                Producción
            </td>
            <td>
                <br><br><br><br><br>
                Almacen de telas
            </td>
            <td>
                <br><br><br><br><br>
                Almacén de Habios
            </td>
            <td>
                <br><br><br><br><br>
                Control de calidad
            </td>
            <td>
                <br><br><br><br><br>
                Sala de corte
            </td>
            <td>
                <br><br><br><br><br>
                Almacen producto terminado
            </td>
        </tr>
    </table>
    
</body>
</html>