<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Multi Auth Guard') }} - Detalles de Pedido #{{ $orden->id }}</title>

    <!-- Styles -->
    {{-- <style>
        /* Estilos custom para PDF */
        body {
            background: none !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: "Helvetica";
        }
        tbody:before, tbody:after { display: none; }
    </style> --}}
</head>
<body>
    <div class="row">
        <div class="col-md-10">
            <h3>Privanza</h3>
            <h4>Detalle de Orden #{{ $orden->id }}</h4>
            <p>Datos Generales:</p>
            <ul>
                <li>Vendedor: {{ $orden->vendedor->name }}</li>
                <li>Fecha de Registro: {{ $orden->created_at }}</li>
            </ul>
        </div>
        <div class="col-md-2">
            Fecha de Generación: {{ Carbon\Carbon::now() }}
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h4>Estado General</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-2">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
    </div>
    {{-- Estado de Producción --}}
    <div class="row">
        <div class="col-xs-12">
            <h4>Estado de Producción</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-3">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-3">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
        <div class="col-xs-3">
            <p>
                Aprobado: {{ $orden->approved ? 'Sí':'No' }}
            @if ($orden->approved)
                <br>
                Fecha: {{ $orden->date_approved }}
            @endif
            </p>    
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <th>l1</th>
                <th>l2</th>
                <th>l3</th>
                <th>lala</th>
            </thead>
            <tbody>
                <tr>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                </tr>
                <tr>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                </tr>
                <tr>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                </tr>
                <tr>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                </tr>
                <tr>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                    <td>asodfjasoidf</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>