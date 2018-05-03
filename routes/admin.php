<?php

// Dashboard
Route::get('/dashboard','DashboardController@adminDash');

// Clientes functionality
Route::get('/clientes','ClientController@indexForAdmin');
Route::get('/clientes/agregar', 'ClientController@createForAdmin');
Route::post('/clientes','ClientController@storeForAdmin');
Route::get('/clientes/{client}','ClientController@showForAdmin');
Route::get('/clientes/{client}/editar','ClientController@editForAdmin');
Route::put('/clientes/{client}','ClientController@updateForAdmin');

// Orders
Route::get('/ordenes','OrderController@indexForAdmin');
Route::get('/ordenes/agregar', 'OrderController@createForAdmin');
Route::post('/ordenes','OrderController@storeForAdmin');
Route::get('/ordenes/{order}','OrderController@showForAdmin');
Route::get('/ordenes/{order}/editar','OrderController@editForAdmin');
Route::put('/ordenes/{order}','OrderController@updateForAdmin');
Route::get('/ordenes/{order}/approved','OrderController@approveOrder');
Route::get('/ordenes/{order}/produccion','OrderController@productionOrder');
Route::get('/ordenes/{order}/produccionCorte','OrderController@productionCorteOrder');
Route::get('/ordenes/{order}/produccionEnsamble','OrderController@productionEnsambleOrder');
Route::get('/ordenes/{order}/produccionPlancha','OrderController@productionPlanchaOrder');
Route::get('/ordenes/{order}/produccionRevision','OrderController@productionRevisionOrder');
Route::get('/ordenes/{order}/pickup','OrderController@pickupOrder');
Route::get('/ordenes/{order}/delivered','OrderController@deliveredOrder');
Route::get('/ordenes/{order}/charged','OrderController@chargedOrder');
Route::get('/ordenes/{order}/invoiced','OrderController@invoicedOrder');

// Ajustes
Route::get('/ajustes','AdjustmentController@indexForAdmin');
Route::get('/ajustes/agregar', 'AdjustmentController@createForAdmin');
Route::post('/ajustes','AdjustmentController@storeForAdmin');
Route::get('/ajustes/{ajuste}','AdjustmentController@showForAdmin');
Route::get('/ajustes/{ajuste}/editar','AdjustmentController@editForAdmin');
Route::put('/ajustes/{ajuste}','AdjustmentController@updateForAdmin');

// Events
Route::get('/citas','EventController@indexForAdmin');
Route::get('/citas/agregar','EventController@createForAdmin');
Route::post('/citas','EventController@storeForAdmin');
Route::get('/citas/{cita}','EventController@showForAdmin');
Route::get('/citas/{cita}/editar','EventController@editForAdmin');
Route::put('/citas/{cita}','EventController@updateForAdmin');

// Vendedores
Route::get('/vendedores','VendedorController@indexForAdmin');
Route::get('/vendedores/agregar','VendedorController@createForAdmin');
Route::post('/vendedores','VendedorController@storeForAdmin');
Route::get('/vendedores/{vendedor}','VendedorController@showForAdmin');
Route::get('/vendedores/{vendedor}/editar','VendedorController@editForAdmin');
Route::put('/vendedores/{vendedor}','VendedorController@updateForAdmin');

// Validadores
Route::get('/validadores','ValidadorController@index');
Route::get('/validadores/agregar','ValidadorController@create');
Route::post('/validadores','ValidadorController@store');
Route::get('/validadores/{validador}','ValidadorController@show');
Route::get('/validadores/{validador}/editar','ValidadorController@edit');
Route::put('/validadores/{validador}','ValidadorController@update');
Route::get('/validadores/{validador}/activar','ValidadorController@activar');
Route::get('/validadores/{validador}/desactivar','ValidadorController@desactivar');

// Profile
Route::put('/perfil','ProfileController@actualizarPerfilAdmin');
Route::get('/perfil','ProfileController@perfilAdmin');
Route::get('/perfil/editar', 'ProfileController@editarPerfilAdmin');

// Configuration
Route::put('/configuracion','ConfigurationController@update');
Route::get('/configuracion','ConfigurationController@index');
