<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.dashboard');
})->name('home');

// Static Route to get the matching order based on the Production Order Number
Route::get('/op/{op}', function($op){
	$orden = App\Order::where('consecutivo_op',$op)->get();
	return $orden;
});

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
Route::get('/ordenes/{order}/aprobar');

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
Route::get('/vendedores','VendedorController@index');
Route::get('/vendedores/agregar','VendedorController@create');
Route::post('/vendedores','VendedorController@store');
Route::get('/vendedores/{vendedor}','VendedorController@show');
Route::get('/vendedores/{vendedor}/editar','VendedorController@edit');
Route::put('/vendedores/{vendedor}','VendedorController@update');
Route::get('/vendedores/{vendedor}/activar','VendedorController@activar');
Route::get('/vendedores/{vendedor}/desactivar','VendedorController@desactivar');

// Validadores
Route::get('/validadores','ValidadorController@index');
Route::get('/validadores/agregar','ValidadorController@create');
Route::post('/validadores','ValidadorController@store');
Route::get('/validadores/{validador}','ValidadorController@show');
Route::get('/validadores/{validador}/editar','ValidadorController@edit');
Route::put('/validadores/{validador}','ValidadorController@update');
Route::get('/validadores/{validador}/activar','ValidadorController@activar');
Route::get('/validadores/{validador}/desactivar','ValidadorController@desactivar');


