<?php

// Dashboard
Route::get('/dashboard','DashboardController@vendedorDash')->name('dashboard');

// Clientes
Route::get('/clientes','ClientController@indexVendedor');
Route::get('/clientes/agregar', 'ClientController@create');
Route::post('/clientes','ClientController@store');
Route::get('/clientes/{client}','ClientController@show');
Route::get('/clientes/{client}/editar','ClientController@edit');
Route::put('/clientes/{client}','ClientController@update');

// Orders
Route::get('/ordenes','OrderController@index');
Route::get('/ordenes/agregar', 'OrderController@create');
Route::post('/ordenes','OrderController@store');
Route::get('/ordenes/{order}','OrderController@show');
Route::get('/ordenes/{order}/editar','OrderController@edit');
Route::put('/ordenes/{order}','OrderController@update');
Route::get('/ordenes/{order}/pdf','OrderController@orderpdf');

// Events
Route::get('/citas','EventController@index');
Route::get('/citas/agregar','EventController@create');
Route::post('/citas','EventController@store');
Route::get('/citas/{cita}','EventController@show');
Route::get('/citas/{cita}/editar','EventController@edit');
Route::put('/citas/{cita}','EventController@update');

// Profile
Route::get('/perfil','ProfileController@index');
Route::get('/perfil/solicitarCambio', 'ProfileController@askDataChange');

Route::get('/pruebamail', function() {
    return view('mails.action',[
        'asunto' => 'Pedido #23 Aprobado.',
        'urlAccion' => '/vendedor/ordenes/1',
        'cuerpo' => 'El pedido ahora se encuentra aprobado, en 24 horas deberá ingresar a producción y posteriormente podrás recogerlo en las instalaciones de Privanza. Si deseas más información puedes consultarla haciendo click en el siguiente botón:'
    ]);
});
