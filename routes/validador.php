<?php

Route::get('/dashboard', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('validador')->user();

    //dd($users);

    return view('validador.dashboard');
})->name('dashboard');

Route::get('/dashboard','DashboardController@validadorDash')->name('dashboard');

// Clientes functionality
Route::get('/clientes','ClientController@indexForValidador');
Route::get('/clientes/agregar', 'ClientController@createForValidador');
Route::post('/clientes','ClientController@storeForValidador');
Route::get('/clientes/{client}','ClientController@showForValidador');
Route::get('/clientes/{client}/editar','ClientController@editForValidador');
Route::put('/clientes/{client}','ClientController@updateForValidador');

// Orders
Route::get('/ordenes','OrderController@index');
Route::get('/ordenes/agregar', 'OrderController@create');
Route::post('/ordenes','OrderController@store');
Route::get('/ordenes/{order}','OrderController@show');
Route::get('/ordenes/{order}/editar','OrderController@edit');
Route::put('/ordenes/{order}','OrderController@update');
//Estado general de la orden
Route::get('/ordenes/{order}/aprobar','OrderController@approveOrder'); //Aprobar
Route::get('/ordenes/{order}/produccion','OrderController@productionOrder'); //Producción
Route::get('/ordenes/{order}/recoleccion','OrderController@pickupOrder'); //Recolección
Route::get('/ordenes/{order}/entrega','OrderController@deliveredOrder'); //Entregado
Route::get('/ordenes/{order}/factura','OrderController@invoicedOrder');//Facturado
Route::get('/ordenes/{order}/cobro','OrderController@chargedOrder');//Cobrado
//Estado de produccion
Route::get('/ordenes/{order}/corte','OrderController@productionCorteOrder'); //Corte
Route::get('/ordenes/{order}/ensamble','OrderController@productionEnsambleOrder'); //Ensamble
Route::get('/ordenes/{order}/plancha','OrderController@productionPlanchaOrder'); //Plancha
Route::get('/ordenes/{order}/revision','OrderController@productionRevisionOrder'); //Revision
//Editar precio
Route::get('/ordenes/{order}/editarPrecioOP','OrderController@editPrecioOPForValidador');
Route::put('/ordenes/{order}','OrderController@updatePrecioOPForValidador');

// Ajustes
Route::get('/ajustes','AdjustmentController@indexForValidador');
Route::get('/ajustes/agregar', 'AdjustmentController@createForValidador');
Route::post('/ajustes','AdjustmentController@storeForValidador');
Route::get('/ajustes/{ajuste}','AdjustmentController@showForValidador');
Route::get('/ajustes/{ajuste}/editar','AdjustmentController@editForValidador');
Route::put('/ajustes/{ajuste}','AdjustmentController@updateForValidador');

// Events
Route::get('/citas','EventController@indexForValidador');
Route::get('/citas/agregar','EventController@createForValidador');
Route::post('/citas','EventController@storeForValidador');
Route::get('/citas/{cita}','EventController@showForValidador');
Route::get('/citas/{cita}/editar','EventController@editForValidador');
Route::put('/citas/{cita}','EventController@updateForValidador');

// Vendedores
Route::get('/vendedores','VendedorController@index');
Route::get('/vendedores/agregar','VendedorController@create');
Route::post('/vendedores','VendedorController@store');
Route::get('/vendedores/{vendedor}','VendedorController@show');
Route::get('/vendedores/{vendedor}/editar','VendedorController@edit');
Route::put('/vendedores/{vendedor}','VendedorController@update');

// Profile
Route::get('/perfil','ProfileController@perfilValidador');
Route::get('/perfil/solicitarCambio', 'ProfileController@dataChangeValidador');

Route::get('/ordenes/{order}/pdf','OrderController@pdfForVendedor');
