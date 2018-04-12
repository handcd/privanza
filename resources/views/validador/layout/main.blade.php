<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('img/privanzaN.png') }}" />
    <link rel="icon" type="image/png" href="{{ url('img/privanzaN.png') }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Privanza | Validador</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--     Fonts and icons     -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="{{ asset('css/material-dashboard.css?v=1.2.0') }}" rel="stylesheet" />
    

    <!--   Core JS Files   -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/material.min.js') }}" type="text/javascript"></script>
    <!--  Charts Plugin -->
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <!--  Dynamic Elements plugin -->
    <script src="{{ asset('js/arrive.min.js') }}"></script>
    <!--  PerfectScrollbar Library -->
    <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="{{ asset('js/material-dashboard.js?v=1.2.0') }}"></script>
    
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="{{ asset('img/sidebar-0.png') }}">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

        Tip 2: you can also add an image using data-image tag
    -->
            <div class="logo">
                <a href="{{ url('/validador') }}" class="simple-text">
                    Privanza
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li {{ Request::path() == 'validador/dashboard' ? ' class=active' : '' }}>
                        <a href="{{ url('/validador/dashboard') }}">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li {{ Request::path() == 'validador/ordenes' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/ordenes') }}">
                            <i class="material-icons">content_paste</i>
                            <p>Órdenes</p>
                        </a>
                    </li>
                    <li {{ Request::path() == 'validador/clientes' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/clientes') }}">
                            <i class="material-icons">people</i>
                            <p>Clientes</p>
                        </a>
                    </li>
                    <li {{ Request::path() == 'validador/vendedores' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/vendedores') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <p>Vendedores</p>
                        </a>
                    </li>
                    <li {{ Request::path() == 'validador/ajustes' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/ajustes') }}">
                            <i class="material-icons">tune</i>
                            <p>Ajustes</p>
                        </a>
                    </li>
                     <li {{ Request::path() == 'validador/citas' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/citas') }}">
                            <i class="material-icons">date_range</i>
                            <p>Citas</p>
                        </a>
                    </li>
                    <li {{ Request::path() == 'validador/perfil' ? ' class=active' : '' }}>
                        <a href="{{ url('validador/perfil') }}">
                            <i class="material-icons">person</i>
                            <p>Mi Perfil</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{ url('/validador') }}">Validador</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#pablo" class="dropdown-toggle" data-toggle="dropdown">
                                   <i class="material-icons">person</i>
                                   <p class="hidden-lg hidden-md">{{ Auth::user()->name }}</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ url('/validador/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerrar Sesión
                                        </a>
                                        <form id="logout-form" action="{{ url('/validador/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <form class="navbar-form navbar-right" role="search" style="display: none;">
                            <div class="form-group  is-empty">
                                <input type="text" class="form-control" placeholder="Search">
                                <span class="material-input"></span>
                            </div>
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i><div class="ripple-container"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        Hecho con <i class="fa fa-heart" aria-hidden="true"></i> por <a href="http://handcd.com">Hand Creative Design</a>
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
<script>
/*
    Beautiful notifications.
    {{--
    Use:

    Flash the session with the key being one of: 'danger','warning','success' or 'info',
    and the following function will display a beautiful notification on the top right corner.
    It'll automatically select the more adequate icon and color based on the given key.

    Example:

    Session::flash('danger','You're about to die!');
    -> Displays a Red notification with a danger icon

    Session::flash('warning','You may be about to die!');
    -> Displays a Yellow notification with a warning icon

    And so on.

    TODO: Fix that this function only works one message at a time.
    --}}
*/
@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(Session::has($key))
        $.notify({
            icon: @switch($key)
                @case('danger')
                    'error'
                    @break
                @case('warning')
                    'warning'
                    @break
                @case('success')
                    'done'
                    @break
                @default
                    'notifications'
            @endswitch
            ,
            message: '{{ Session::get($key) }}'
        },{
            type: '{{ $key }}'
        });
    @endif
@endforeach
</script>
</html>