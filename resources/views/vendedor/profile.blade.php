@extends('vendedor.layout.main')

@section('content')
<div class="row">
     <div class="col-md-4">
        <div class="card card-profile">
            <div class="card-avatar">
                <a href="#pablo">
                    <img class="img" src="{{ asset('img/faces/marc.jpg') }}" />
                </a>
            </div>
            <div class="content">
                <h4 class="card-title">Juan Pérez</h4>
                <div class="card-content table-responsive">
                    <h4>Últimas comisiones</h4>
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$3,120.00</td>
                            <td>11/10/2017</td>
                        </tr>
                        <tr>
                            <td>$2,162.30</td>
                            <td>11/9/2017</td>
                        </tr>
                        <tr>
                            <td>$1,162.30</td>
                            <td>11/8/2017</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title">Editar Perfil</h4>
                <p class="category">Por favor, completa tu información</p>
            </div>
            <div class="card-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h4 class="title">Resumen de mi cuenta</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <th>Total de Comisiones del mes</th>
                                <th>Próximo depósito</th>
                            </thead>
                            <tbody>
                                <td>$4,500.00</td>
                                <td id="date"></td>    
                            </tbody>
                        </table>
                        <h5>Fecha de corte de comisiones</h5>
                        <h6>15 de cada mes</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>Datos del vendedor</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Nombre completo:</label>
                        <p>Juan Pérez</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Domicilio</label>
                        <p>Paseo de Los Tamarindos no.384 Col. Campestre Palo Alto</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-primary">Email</label>
                        <p>juan@ejemplo.com</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-primary">Teléfono de contacto</label>
                        <p>5555 5555</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Solicitar cambio de información</button>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection