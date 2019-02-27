@extends('admin.layout.main')

@section('content')
<div class="row">
     <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="fa fa-flag"></i>
            </div>
            <div class="card-content">
                <p class="category">Total vendido del mes</p>
                <h4 class="title">${{ $totalVendido }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="material-icons">content_copy</i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes por aprobar</p>
                <h3 class="title">{{ $sinAprobar }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">check</i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes aprobadas (cotizadas)</p>
                <h3 class="title">{{ $aprobadas }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="purple">
                <i class="fa fa-industry"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes en producción</p>
                <h3 class="title">{{ $produccion }}</h3>
            </div>           
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="fa fa-truck"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes para Recolección</p>
                <h3 class="title">{{ $recoleccion }}</h3>
            </div>           
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="purple">
                <i class="fa fa-smile-o"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes Entregadas</p>
                <h3 class="title">{{ $entregadas }}</h3>
            </div>           
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="fa fa-thumbs-o-up"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes Facturadas</p>
                <h3 class="title">{{ $facturadas }}</h3>
            </div>           
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="orange">
                <i class="fa fa-money"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes Cobradas</p>
                <h3 class="title">{{ $cobradas }}</h3>
            </div>           
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="ventasMes"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Ventas del mes</h4>
                <p class="category">
                    Análisis del progreso en ventas por semana del mes en curso.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-chart" data-background-color="orange">
                <div class="ct-chart" id="ventasEspecie"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Prendas Vendidas</h4>
                <p class="category">Número de trajes vendidos en el año en curso.</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al corte del mes anterior.
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-chart" data-background-color="blue">
                <div class="ct-chart" id="ventasGanancias"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Monto Vendido</h4>
                <p class="category">Cantidad de Dinero vendido por mes el último año.</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al corte del mes anterior.
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="purple">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title">Cumpleaños de Clientes:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#today" data-toggle="tab">
                                    <i class="material-icons">today</i> Hoy
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="">
                                <a href="#week" data-toggle="tab">
                                    <i class="material-icons">view_week</i> Esta Semana
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="">
                                <a href="#month" data-toggle="tab">
                                    <i class="material-icons">date_range</i> Este Mes
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="today">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($birthdaysToday as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->name.' '.$cliente->lastname }}</td>
                                    <td>{{ $cliente->birthday }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('/vendedor/clientes/'.$cliente->id) }}" type="button" rel="tooltip" title="Ver Cliente" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Ningún cliente cumple años hoy :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="week">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($birthdaysWeek as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->name.' '.$cliente->lastname }}</td>
                                    <td>{{ $cliente->birthday }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('/vendedor/clientes/'.$cliente->id) }}" type="button" rel="tooltip" title="Ver Cliente" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Ningún cliente cumple años esta semana :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="month">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($birthdaysMonth as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->name.' '.$cliente->lastname }}</td>
                                    <td>{{ $cliente->birthday }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('/vendedor/clientes/'.$cliente->id) }}" type="button" rel="tooltip" title="Ver Cliente" class="btn btn-primary btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Ningún cliente cumple años este mes :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-nav-tabs">
            <div class="card-header" data-background-color="blue">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title">Citas con Clientes:</span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="#todayEvents" data-toggle="tab">
                                    <i class="material-icons">today</i> Hoy
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="">
                                <a href="#weekEvents" data-toggle="tab">
                                    <i class="material-icons">view_week</i> Esta Semana
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-content">
                <div class="tab-content">
                    <div class="tab-pane active" id="todayEvents">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Fecha/Hora</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosHoy as $evento)
                                <tr>
                                    <td>{{ $evento->id }}</td>
                                    <td><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name.' '.$evento->client->lastname }}</a></td>
                                    <td>{{ $evento->fechahora }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('/vendedor/citas/'.$evento->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                        @if (!Carbon\Carbon::parse($evento->fechahora)->isPast())
                                             <a href="{{ url('/vendedor/citas/'.$evento->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No tienes citas el día de hoy :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="weekEvents">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($eventosSemana as $evento)
                                <tr>
                                    <td>{{ $evento->id }}</td>
                                    <td><a href="{{ url('/vendedor/clientes/'.$evento->client->id) }}">{{ $evento->client->name.' '.$evento->client->lastname }}</a></td>
                                    <td>{{ $evento->fechahora }}</td>
                                    <td class="td-actions text-right">
                                        <a href="{{ url('/vendedor/citas/'.$evento->id) }}" type="button" rel="tooltip" title="Ver Cita" class="btn btn-success btn-simple btn-xs">
                                            <i class="material-icons">remove_red_eye</i>
                                        </a>
                                        @if (!Carbon\Carbon::parse($evento->fechahora)->isPast())
                                             <a href="{{ url('/vendedor/citas/'.$evento->id.'/editar') }}" type="button" rel="tooltip" title="Editar Cita" class="btn btn-primary btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No tienes citas el día de hoy :(</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        // Ventas en Dinero (Año)
        dataDailySalesChart = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            series: [
                [
                @foreach ($prendasVendidas as $prendas)
                    {{ $prendas }},
                @endforeach
                ],
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ max($prendasVendidas)*1.3 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 0
            },
        }

        var dailySalesChart = new Chartist.Line('#ventasEspecie', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);

        // Ventas en Especie (Año)
        dataCompletedTasksChart = {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            series: [
                [
                @foreach ($montoVentas as $monto)
                    {{ $monto }},
                @endforeach
                ]
            ]
        };

        optionsCompletedTasksChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ max($montoVentas)*1.3 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: {
                top: 0,
                right: 0,
                bottom: 0,
                left: 10
            }
        }

        var completedTasksChart = new Chartist.Line('#ventasGanancias', dataCompletedTasksChart, optionsCompletedTasksChart);

        // start animation for the Completed Tasks Chart - Line Chart
        md.startAnimationForLineChart(completedTasksChart);


        // Ventas Mes (Especie)
        var dataEmailsSubscriptionChart = {
            labels: ['S1','S2','S3','S4'],
            series: [
                [
                @foreach ($ventasPorSemana as $monto)
                    {{ $monto }},
                @endforeach
                ]

            ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: true
            },
            low: 0,
            high: {{ max($ventasPorSemana)*1.3 }},
            chartPadding: {
                top: 0,
                right: 5,
                bottom: 0,
                left: 0
            }
        };
        var responsiveOptions = [
            ['screen and (max-width: 640px)', {
                seriesBarDistance: 5,
                axisX: {
                    labelInterpolationFnc: function(value) {
                        return value[0];
                    }
                }
            }]
        ];
        var emailsSubscriptionChart = Chartist.Bar('#ventasMes', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart, responsiveOptions);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);
    });
</script>
@endsection
