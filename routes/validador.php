<?php

Route::get('/dashboard', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('validador')->user();

    //dd($users);

    return view('validador.dashboard');
})->name('dashboard');

// Clientes functionality
Route::get('/clientes','ClientController@index');
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
Route::get('/ordenes/{order}/aprobar');

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
Route::get('/vendedores/{vendedor}/activar','VendedorController@activar');
Route::get('/vendedores/{vendedor}/desactivar','VendedorController@desactivar');

// Profile
Route::get('/perfil','ProfileController@perfilValidador');
Route::get('/perfil/solicitarCambio', 'ProfileController@dataChangeValidador');
