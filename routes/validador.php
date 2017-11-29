<?php

Route::get('/dashboard', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('validador')->user();

    //dd($users);

    return view('validador.dashboard');
})->name('dashboard');

// Clientes functionality
Route::get('/clientes','Validador\ClientController@index');
Route::get('/clientes/agregar', 'Validador\ClientController@create');
Route::post('/clientes','Validador\ClientController@store');
Route::get('/clientes/{client}','Validador\ClientController@show');
Route::get('/clientes/{client}/editar','Validador\ClientController@edit');
Route::put('/clientes/{client}','Validador\ClientController@update');

// Orders
Route::get('/ordenes','Validador\OrderController@index');
Route::get('/ordenes/agregar', 'Validador\OrderController@create');
Route::post('/ordenes','Validador\OrderController@store');
Route::get('/ordenes/{order}','Validador\OrderController@show');
Route::get('/ordenes/{order}/editar','Validador\OrderController@edit');
Route::put('/ordenes/{order}','Validador\OrderController@update');
Route::get('/ordenes/{order}/aprobar');

// Vendedores
Route::get('/vendedores','Validador\VendedorController@index');
Route::get('/vendedores/agregar','Validador\VendedorController@create');
Route::post('/vendedores','Validador\VendedorController@store');
Route::get('/vendedores/{vendedor}','Validador\VendedorController@show');
Route::get('/vendedores/{vendedor}/editar','Validador\VendedorController@edit');
Route::put('/vendedores/{vendedor}','Validador\VendedorController@update');
Route::get('/vendedores/{vendedor}/activar','Validador\VendedorController@activar');
Route::get('/vendedores/{vendedor}/desactivar','Validador\VendedorController@desactivar');

// Profile
Route::get('/perfil','Validador\ProfileController@index');
Route::get('/perfil/solicitarCambio', 'Validador\ProfileController@askDataChange');
