<?php

// Dashboard
Route::get('/dashboard', function () {
    /*$users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();*/

    //dd($users);

    return view('vendedor.dashboard');
})->name('dashboard');

// Clientes functionality
Route::get('/clientes','Vendedor\ClientController@index');
Route::get('/clientes/agregar', 'Vendedor\ClientController@create');
Route::post('/clientes','Vendedor\ClientController@store');
Route::get('/clientes/{client}','Vendedor\ClientController@show');
Route::get('/clientes/{client}/editar','Vendedor\ClientController@edit');
Route::put('/clientes/{client}','Vendedor\ClientController@update');

// Orders
Route::get('/ordenes','Vendedor\OrderController@index');
Route::get('/ordenes/agregar', 'Vendedor\OrderController@create');
Route::post('/ordenes','Vendedor\OrderController@store');
Route::get('/ordenes/{order}','Vendedor\OrderController@show');
Route::get('/ordenes/{order}/editar','Vendedor\OrderController@edit');
Route::put('/ordenes/{order}','Vendedor\OrderController@update');

// Profile
Route::get('/perfil','Vendedor\ProfileController@index');
Route::get('/perfil/solicitarCambio', 'Vendedor\ProfileController@askDataChange');
