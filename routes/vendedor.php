<?php

// Dashboard
Route::get('/dashboard','DashboardController@vendedorDash')->name('dashboard');

// Clientes
Route::get('/clientes','ClientController@indexForVendedor');
Route::get('/clientes/agregar', 'ClientController@createForVendedor');
Route::post('/clientes','ClientController@storeForVendedor');
Route::get('/clientes/{client}','ClientController@showForVendedor');
Route::get('/clientes/{client}/editar','ClientController@editForVendedor');
Route::put('/clientes/{client}','ClientController@updateForVendedor');

// Orders
Route::get('/ordenes','OrderController@indexForVendedor');
Route::get('/ordenes/agregar', 'OrderController@createForVendedor');
Route::post('/ordenes','OrderController@storeForVendedor');
Route::get('/ordenes/{order}','OrderController@showForVendedor');
Route::get('/ordenes/{order}/editar','OrderController@editForVendedor');
Route::put('/ordenes/{order}','OrderController@updateForVendedor');
Route::get('/ordenes/{order}/pdf','OrderController@orderpdfForVendedor');

// Events
Route::get('/citas','EventController@indexForVendedor');
Route::get('/citas/agregar','EventController@createForVendedor');
Route::post('/citas','EventController@storeForVendedor');
Route::get('/citas/{cita}','EventController@showForVendedor');
Route::get('/citas/{cita}/editar','EventController@editForVendedor');
Route::put('/citas/{cita}','EventController@updateForVendedor');

// Profile
Route::get('/perfil','ProfileController@perfilVendedor');
Route::get('/perfil/solicitarCambio', 'ProfileController@dataChangeVendedor');
