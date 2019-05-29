<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/privanzaN.png') }}" />
        <link rel="icon" type="image/png" href="{{ url('img/privanzaN.png') }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TAILORED</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            @media (max-width: 599px) {
                .title {
                    font-size: 60px;
                }

                .links > a {
                    font-size: 15px;
                    padding: 0 50px;
                }
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    TAILORED
                </div>

                <div class="links">
                    <a href="{{ url('/vendedor/login') }}">Vendedores</a>
                    <a href="{{ url('/validador/login') }}">Validadores</a>
                    <a href="{{ url('/admin/login') }}">Administradores</a>
                </div>
            </div>
        </div>
    </body>
</html>
