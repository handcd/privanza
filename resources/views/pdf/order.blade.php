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

    <title>Privanza | Detalles de pedido #{{ $orden->id }}</title>

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
        .page-break {
            page-break-after: always;
        }
        tbody:before, tbody:after { display: none; }
    </style> 
</head>
<body>
    <div class="row">
        <div class="col-md-10 text-center">
            <h3>Privanza | Detalle de pedido #{{ $orden->id }} | Órden producción  </h3>
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
            <th colspan="4" class="text-center">
                Generales
            </th>
            <th colspan="6" class="text-center">
                Medidas corporales
            </th>
        </tr>
        <tr>
            <td>
                Altura:
                <br>
                @if($orden->client->altura)                
                    {{ $orden->client->altura  }} Cm.
                @else
                     
                @endif 
            </td>
            <td>
                Peso:
                <br>
                @if($orden->client->peso)
                    {{ $orden->client->peso  }} Kg.
                @else
                     
                @endif
            </td>
            <td colspan="2">
                Edad:
                <br>
                @if($orden->client->edad)
                    {{ $orden->client->edad  }} años
                @else
                     
                @endif
            </td>
            <td>
                Contorno de cuello:
                <br>
                @if($orden->client->contornoCuello)
                    {{ $orden->client->contornoCuello  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de biceps:
                <br>
                @if($orden->client->contornoBiceps)
                    {{ $orden->client->contornoBiceps  }} pulgadas 
                @else
                     
                @endif
            </td>
            <td>
                Largo brazo derecho:
                <br>
                @if($orden->client->brazoDerecho)
                    {{ $orden->client->brazoDerecho  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo brazo izquierdo:
                <br>
                @if($orden->client->brazoIzquierdo)
                    {{ $orden->client->brazoIzquierdo  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo hombro derecho:
                <br>
                @if($orden->client->hombroDerecho)
                    {{ $orden->client->hombroDerecho  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo hombro izquierdo:
                <br>
                @if($orden->client->hombroIzquierdo)
                    {{ $orden->client->hombroIzquierdo  }} pulgadas
                @else
                     
                @endif
            </td>
        </tr>
        <tr>
            <th colspan="4" class="text-center">
                Perfil: constitución del cliente
            </th>
            <td>
                Medida de hombros:
                <br>
                @if($orden->client->medidaHombros)
                    {{ $orden->client->medidaHombros  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Ancho espalda:
                <br>
                @if($orden->client->anchoEspalda)
                    {{ $orden->client->anchoEspalda  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de puño:
                <br>
                @if($orden->client->punio)
                    {{ $orden->client->punio }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo de torso:
                <br>
                @if($orden->client->largoTorso)
                    {{ $orden->client->largoTorso }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de pecho:
                <br>
                @if($orden->client->contornoPecho)
                    {{ $orden->client->contornoPecho }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de abdomen:
                <br>
                @if($orden->client->contornoAbdomen)
                    {{ $orden->client->contornoAbdomen }} pulgadas
                @else
                     
                @endif
            </td>
        </tr>
        <tr>
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
                     
                @endif
            </td>
            <td>
                Tipo de hombros:
                <br>
                @switch( $orden->client->hombros )
                    @case(0)
                          <p>Rectos</p>
                          @break
                    @case(1)
                          <p>Normales</p>
                          @break
                    @case(2)
                          <p>Caídos</p>
                          @break
                    @default
                          <p>Entrada inválida</p>
                  @endswitch
            </td>
            <td>
                Contorno de cintura:
                <br>
                @if($orden->client->contornoCintura)
                    {{ $orden->client->contornoCintura }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de cadera:
                <br>
                @if($orden->client->contornoCadera)
                    {{ $orden->client->contornoCadera  }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo externo de pantalón:
                <br>
                @if($orden->client->largoExternoPantalon )
                    {{ $orden->client->largoExternoPantalon }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Largo interno de pantalón:
                <br>
            @if($orden->client->largoInternoPantalon)
                {{ $orden->client->largoInternoPantalon }} pulgadas
            @else
                 
            @endif
            </td>
            <td>
                Largo de tiro:
                <br>
                @if($orden->client->largoTiro)
                    {{ $orden->client->largoTiro }} pulgadas
                @else
                     
                @endif
            </td>
            <td>
                Contorno de muslo:
                <br>
                @if( $orden->client->contornoMuslo)
                    {{ $orden->client->contornoMuslo }} pulgadas
                @else
                     
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="4">
                
            </td>
            <td>
                Contorno de Rodilla:
                <br>
                @if( $orden->client->contornoRodilla )
                    {{ $orden->client->contornoRodilla }} pulgadas
                @else
                     
                @endif
            </td>
            <td colspan="5">
                
            </td>
        </tr>

    </table>
    {{--Detalles generales del pedido--}}
<<<<<<< HEAD
    <h4>Materiales</h4>
=======
    <h4>Datos básicos del pedido</h4>
>>>>>>> 5d81f0b079ab69f12dcc1a0290c3bd2cf056fa28
    <table class="table table-bordered">
        <tr>
            <th>
                Tela
            </th>
            @if( $orden->tela_isco === 1 )
            <td>
                Tipo de tela: 
                ISCO
            </td>
            @elseif($orden->tela_isco === 0)
                <td>
                Tipo de tela: 
                Del cliente
            </td>
            @else
                <td>
                    
                </td>
            @endif
            <td>
                Código: 
                @if( $orden->codigo_tela )
                    {{ $orden->codigo_tela }}
                @else

                @endif
            </td>
            <td>
                Nombre: 
                @if($orden->nombre_tela)
                {{ $orden->nombre_tela }}
                @else

                @endif
            </td>
            <td>
                Color:
                @if($orden->codigo_color_tela && $orden->color_tela)
                {{ $orden->codigo_color_tela }} {{ $orden->color_tela }}
                @else

                @endif
            </td>
            @if( $orden->tela_isco === 0 )
                <td>
                    Metros: {{ $orden->mts_tela_cliente }}
                </td>
            @else
                Metros:
            @endif
        </tr>
        <tr>
            <th> 
                Forro
            </th>
            @if( $orden->forro_isco === 1 )
                <td>
                    Tipo de forro: 
                    ISCO
                </td>
            @else
                <td>
                    Tipo de forro: 
                    Del cliente
                </td>
            @endif
            <td>
                Código: 
                @if($orden->codigo_forro)
                    {{ $orden->codigo_forro }}
                @else

                @endif
            </td>
            <td>
                Nombre: 
                @if($orden->nombre_forro)
                {{ $orden->nombre_forro }}
                @else

                @endif
            </td>
            <td>
                Color:
                @if($orden->codigo_color_forro && $orden->color_forro)
                {{ $orden->codigo_color_forro }} {{ $orden->color_forro }}
                @else

                @endif
            </td>
            @if( $orden->forro_isco === 0 )
                <td>
                    Metros entregados: {{ $orden->mts_forro_cliente }}
                </td>
            @else
                <td>
                    Metros entregados:
                </td>
            @endif
        </tr>
        <tr>
            <th> 
                Botones
            </th>
            @if( $orden->tipo_botones === 1)
                <td>
                    Tipo de Botones: 
                    Del cliente
                </td>
            @elseif($orden->tipo_botones === 0)
                <td>
                    Tipo de botones: 
                    ISCO
                </td>
            @else 
                <td>
                    Tipo de botones:
                </td>
            @endif
            <td>
                Código: 
                @if($orden->codigo_botones)
                {{ $orden->codigo_botones }}
                @else

                @endif
            </td>
            <td>
                Color:
                @if($orden->codigo_color_botones && $orden->color_botones )
                {{ $orden->codigo_color_botones }} {{ $orden->color_botones }}
                @else
                    
                @endif
            </td>
            @if( $orden->tipo_botones === 1 )
                <td>
                    Cantidad: {{ $orden->cantidad_botones }}
                </td>
            @else
                <td>
                    
                </td>
            @endif
            @if( $orden->forro_isco === 0)
                <td>
                    
                </td>
            @endif
        </tr>
        <tr>
            @if( $orden->etiquetas_tela || $orden->etiquetas_marca)
                <td>
                    <b>Etiquetas:</b> <br>
                    Etiquetas de tela:  
                    @if( $orden->etiquetas_tela === 1 )
                        Sí
                    @else
                        No
                    @endif
                    <br>
                    Etiquetas de marca: 
                    @if( $orden->etiquetas_marca === 1)
                        Sí. {{ $orden->marca_en_etiqueta }}
                    @else
                        No
                    @endif
                </td>
            @else
                <td>
                    <b>Etiquetas: </b><br>
                     
                </td>
            @endif
            @if( $orden->gancho)
                <td>
                    <b>Gancho: </b>
                    <br>
                    @if( $orden->gancho === 0 )
                        Normal
                    @elseif( $orden->gancho === 1)
                        Personalizado privanza. 
                    @else
                        {{ $saco->gancho_personalizacion }}.
                    @endif
                </td>
            @else
                <td>
                    <b>Gancho: </b><br>
                     
                </td>
            @endif
            @if( $orden->portatrajes )
                <td>                    
                    <br>
                    @if( $orden->portatrajes === 0 )
                        <b>Portatrajes: </b><br>
                        Normal
                    @elseif( $orden->portatrajes === 1)
                        <b>Portatrajes: </b><br>
                        Personalizado privanza. 
                    @else
                        {{ $saco->portatrajes_personalizacion }}.
                    @endif
                </td>
            @else
                <td>
                    <b>Portatrajes:</b> <br>
                     
                </td>
            @endif
            @if( $orden->bordado )
                
                <td>
                    <b>Bordado</b>
                    Nombre: {{ $orden->bordado }} <br>
                    Letra: {{ $orden->letra }} <br>
                    Color: {{ $orden->bordadoColor }}
                </td>
            @else
                <td>
                    <b>Bordado: </b><br>
                     
                </td>
            @endif
            
            @if( $orden->forro_isco === 0 || $orden->tela_isco === 0)
                @if( $orden->notasBordado )
                <td colspan="2">
                    Notas: {{ $orden->notas_bordado}}
                </td>
            @else
                <td colspan="2">
                    
                </td>
            @endif
            @else
                @if( $orden->notasBordado )
                    <td>
                        Notas: {{ $orden->notas_bordado}}
                    </td>
                @else
                    <td>
                    
                    </td>
            @endif
            @endif
        </tr>
    </table>
    <br><br>
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
                <th colspan="3" class="text-center">Generales</th>
                <th colspan="5" class="text-center">Cuerpo</th>
            </tr>
            <tr>
                <td>
                    Fit Deseado:
                    <br>
                    @if($saco->fit_id)
                        {{ $saco->fit->name}}
                    @else
                         
                    @endif    
                </td>
                <td>
                    Largo de Manga deseado:
                    <br>
                    @if($saco->talla) 
                        {{ $saco->talla }} pulgadas
                    @else
                         
                    @endif
                </td>
                <td>
                    Largo de espalda deseado:
                    <br>
                    @if($saco->largo_espalda_deseado) 
                        {{ $saco->largo_espalda_deseado }} pulgadas
                    @else
                         
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
            </tr>
            <tr>
                <th colspan="3" class="text-center">Solapa</th>
                <th colspan="5" class="text-center">Mangas</th>
            </tr>
            <tr>
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
                             
                    @endswitch
                </td>
                <td>
                    Color de ojal en solapa:
                    <br>
                    @if( $saco->tipo_ojal_solapa === 2) 
                        En Contraste. Color {{ $saco->color_ojal_solapa}}.
                    @elseif($saco->tipo_ojal_solapa === 1)
                        Al tono
                    @else

                    @endif
                </td>
                <td>
                    Ojal Activo en solapa:
                    <br>
                    @if( $saco->ojal_activo_solapa === 1) 
                        Sí
                    @elseif($saco->ojal_activo_solapa === 0)
                        No
                    @else

                    @endif
                </td>
                <td>
                    Color de ojal en manga: 
                    @if( $saco->tipo_ojal_manga === 2) 
<<<<<<< HEAD
                        En Contraste. Color {{ $saco->color_ojal_manga}}. 
                        @switch($orden->coat->posicion_ojales_contraste)
                            @case(0)
                                    Ojal 1
                                    @break
                            @case(1)
                                    Ojal 4
                                    @break
                            @case(2)
                                    Todos los ojales
                                    @break
                            @default
                        @endswitch
                    @else
=======
                        En Contraste. Color {{ $saco->color_ojal_manga}}.
                    @elseif( $saco->tipo_ojal_manga === 1)
>>>>>>> 5d81f0b079ab69f12dcc1a0290c3bd2cf056fa28
                        Al tono
                    @else

                    @endif
                </td>
                <td colspan="2">
                    Ojal Activo en manga:
                    <br>
                     @if( $saco->ojal_activo_manga === 1) 
                        Sí. Posición de ojales: {{ $saco->posicion_ojales_activos_manga}} 
                    @else
                        No
                    @endif
                </td>
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
                             
                    @endswitch
                </td>
            </tr>
            <tr>
                <th colspan="8" class="text-center">Interior</th>
            </tr>
            <tr>
                <td>
                    Tipo de vista interna:
                    <br>
                    @if( $saco->tipo_vista === 0 )
                        Normal
                    @elseif( $saco->tipo_vista === 1 )
                        Chapeta Francesa
                    @else
                         
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
                <td colspan="2">
                    Accesorios: 
                    @if( $saco->tipoAccesorio == 0)
                        PinPoint. Color {{ $saco->accesorio_color }}
                    @elseif( $saco->tipoAccesorio == 1)
                        Bies. Color {{ $saco->accesorio_color}}
                    @else
                        Pinpoint y bies {{ $saco->accesorio_color}}
                    @endif

                </td>                   
                @if( $saco->bolsas_int )
                    <td colspan="2">
                    Bolsas internas:
                    <br>
                    @switch( $saco->bolsas_int)
                        @case(1) 2 bolsas en pecho, 1 p/pluma, 1 p/cigarrera 
                            @break
                        @case(2) 2 bolsas en pecho, 1 p/pluma
                            @break
                        @case(3) 2 bolsas en pecho, 1 p/cigarrera
                            @break 
                        @case(4) 2 bolsas en pecho
                            @break
                        @default
                            Tipo de bolsas internas
                    @endswitch
                    </td>
                @else
                    <td colspan="2">
                        Tipo de bolsas internas
                    </td>
                @endif
                @if( $saco->vivos_bolsas_internas_cuerpo)
                    <td colspan="2">
                        Vivos en bolsas internas:
                        <br>
                        Del mismo forro en cuerpo
                    </td>
                @elseif( $saco->otro_vivos_bolsas_internas)
                    <td colspan="2">
                        Vivos en bolsas internas:
                        <br>
                        {{ $saco->otro_vivos_bolsas_internas }}
                    </td>
                @else
                    <td colspan="2">
                        Vivos en bolsas internas:
                    </td>
                @endif
            </tr>
            <tr>
                @if( $saco->notas_int &&  $saco->notas_ext)
                    <td colspan="4">
                        Notas de saco externo:
                        <br>
                            {{ $saco->notas_ext }}
                    </td>
                    <td colspan="4">
                        Notas de saco interno:
                        <br>
                            {{ $saco->notas_int }}
                    </td>
                @elseif( $saco->notas_ext)
                    <td colspan="8">
                        Notas de saco externo:
                        <br>
                            {{ $saco->notas_ext }}
                    </td>
                @elseif( $saco->notas_int )
                    <td colspan="8">
                        Notas de saco interno:
                        <br>
                            {{ $saco->notas_int }}
                    </td>
                @else
                    <td colspan="8">    

                    </td>
                @endif
            </tr>
        </table> 
          
    @endif
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
                         
                    @endif    
                </td>
                <td>
                    Largo de espalda deseado:
                    <br>
                    @if($chaleco->talla) 
                        {{ $chaleco->talla }} pulgadas
                    @else
                         
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
                         
                    @endif
                </td>
                @if( $chaleco->notas )
                    <td>
                        @if($chaleco->notas)
                        Notas: {{ $chaleco->notas}}
                        @else

                        @endif
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
                <th colspan="2" class="text-center">
                    Generales
                </th>
                <th colspan="5"></th>
            </tr>
            <tr>
                <td>
                    Fit Deseado:
                    <br>
                    @if($pantalon->fit_id)
                        {{ $pantalon->fit->name }}
                    @else
                         
                    @endif    
                </td>
                <td>
                    Talla de referencia de pantalón:
                    <br>
                    @if($pantalon->talla) 
                        {{ $pantalon->talla }} pulgadas
                    @else
                         
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
                             
                    @endswitch
                </td>
                <td colspan="6">
                    Notas:
                    <br>
                    @if($pantalon->notas)
                    {{ $pantalon->notas }}
                    @else

                    @endif
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
            <td style="height: 30">
                <br><br><br>
                Elaboro (original)
            </td>
            <td>
                <br><br><br>
                Producción
            </td>
            <td>
                <br><br><br>
                Almacen de telas
            </td>
            <td>
                <br><br><br>
                Almacén de Habios
            </td>
            <td>
                <br><br><br>
                Control de calidad
            </td>
            <td>
                <br><br><br>
                Sala de corte
            </td>
            <td>
                <br><br><br>
                Almacen producto terminado
            </td>
        </tr>
    </table>
    
</body>
</html>