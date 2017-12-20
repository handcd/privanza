@extends('vendedor.layout.main')

@section('content')
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('js/demo.js') }}"></script>
<div class="row">
     <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="fa fa-flag"></i>
            </div>
            <div class="card-content">
                <p class="category">Total vendido del mes</p>
                <h3 class="title">{{ $ordenes
                            ->where('cobrado','1')
                            ->where('created_at','>=', Carbon\Carbon::now()->startOfMonth())
                            ->where('created_at','<=', Carbon\Carbon::now()->endOfMonth())
                            ->sum('precio_final')
                        }}</h3>
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
                <h3 class="title">{{ $ordenes->where('approved','0')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons">check</i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes aprobadas</p>
                <h3 class="title">{{ $ordenes->where('approved','1')->count() }}</h3>
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
                <h3 class="title">{{ $ordenes->where('production','1')->count() }}</h3>
            </div>           
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="fa fa-truck"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes para Recolección</p>
                <h3 class="title">{{ $ordenes->where('recoger','1')->count() }}</h3>
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
                <h3 class="title">{{ $ordenes->where('entregado','1')->count() }}</h3>
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
                <h3 class="title">{{ $ordenes->where('facturado','1')->count() }}</h3>
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
                <h3 class="title">{{ $ordenes->where('cobrado','1')->count() }}</h3>
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
                <h4 class="title">Ventas en especie</h4>
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
                <h4 class="title">Ventas en Ganancias</h4>
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
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Cumpleaños de Clientes</h4>
                <p class="category">Clientes que cumplen años en {{ Carbon\Carbon::now()->format('F') }}</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                    </thead>
                    <tbody>
                        @forelse ($birthdays as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$cliente->id) }}">{{ $cliente->name }}</td>
                            <td>{{ Carbon\Carbon::parse($cliente->birthday)->toDateString() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Ningún cliente cumple años este mes :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" data-background-color="green">
                <h4 class="title">Órdenes listas para recoger</h4>
                <p class="category">Pedidos listos para recogerse en ISCO</p>
            </div>
            <div class="card-content table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @forelse ($recoger as $orden)
                        <tr>
                            <td>{{ $orden->id }}</td>
                            <td><a href="{{ url('/vendedor/clientes/'.$orden->client->id) }}">{{ $orden->client->name }}</td>
                            <td class="text-primary">$2,380</td>
                            <td>{{ $orden->created_at }}</td>
                            <td class="td-actions text-right">
                                <a href="{{ url('/vendedor/ordenes/'.$orden->id) }}" type="button" rel="tooltip" title="Ver Orden" class="btn btn-success btn-simple btn-xs">
                                    <i class="material-icons">remove_red_eye</i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No tienes órdenes para recoger este mes :(</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                @php
                    $max = 1;
                @endphp
                @for ($i = 1; $i < 13; $i++)
                    '{{
                        $temp = $ordenes
                            ->where('created_at','>=', Carbon\Carbon::now()->month($i)->startOfMonth())
                            ->where('created_at','<=', Carbon\Carbon::now()->month($i)->endOfMonth())
                            ->count()
                    }}',
                    @php
                        if ($temp > $max) { $max = $temp; }
                    @endphp
                @endfor
                ],
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ $max+10 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
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
                @php
                    $max = 1;
                @endphp
                @for ($i = 1; $i < 13; $i++)
                    '{{
                        $temp = $ordenes
                            ->where('created_at','>=', Carbon\Carbon::now()->month($i)->startOfMonth())
                            ->where('created_at','<=', Carbon\Carbon::now()->month($i)->endOfMonth())
                            ->sum('precio_final')
                    }}',
                    @php
                        if ($temp > $max) { $max = $temp; }
                    @endphp
                @endfor
                ]
            ]
        };

        optionsCompletedTasksChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: {{ $max*1.5 }}, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
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
                @php
                    $max = 1;
                    $dt = Carbon\Carbon::now();
                @endphp
                @for ($i = 0; $i < 4; $i++)
                    '{{
                        $temp = $ordenes
                            ->where('created_at','>=', Carbon\Carbon::now()->startOfMonth()->addWeeks($i)->startOfWeek())
                            ->where('created_at','<=', Carbon\Carbon::now()->startOfMonth()->addWeeks($i)->endOfWeek())
                            ->count()
                    }}',
                    @php
                        if ($temp > $max) { $max = $temp; }
                    @endphp
                @endfor
                ]

            ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: true
            },
            low: 0,
            high: {{ $max+5 }},
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
