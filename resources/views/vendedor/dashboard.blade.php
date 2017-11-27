@extends('vendedor.layout.main')

@section('content')
<div class="row">
     <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="blue">
                <i class="material-icons">store</i>
            </div>
            <div class="card-content">
                <p class="category">Total vendido del mes</p>
                <h3 class="title">$3,245</h3>
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
                <h3 class="title">5</h3>
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
                <h3 class="title">7</h3>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header" data-background-color="purple">
                <i class="fa fa-thumbs-o-up"></i>
            </div>
            <div class="card-content">
                <p class="category">Órdenes en producción</p>
                <h3 class="title">6</h3>
            </div>           
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-chart" data-background-color="green">
                <div class="ct-chart" id="dailySalesChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Ventas del mes</h4>
                <p class="category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> aumento de ventas con respecto al mes anterior</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al día de hoy
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-chart" data-background-color="orange">
                <div class="ct-chart" id="emailsSubscriptionChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Historial de ventas</h4>
                <p class="category">Redimiento de ventas del año en curso</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al día 15 del mes anteior.
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header card-chart" data-background-color="red">
                <div class="ct-chart" id="completedTasksChart"></div>
            </div>
            <div class="card-content">
                <h4 class="title">Comparativo con otros vendedores</h4>
                <p class="category">Tu rendimiento en importe de ventas comparado con otros compañeros</p>
            </div>
            <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">access_time</i> Actualizado al día 15 del mes anterior.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
