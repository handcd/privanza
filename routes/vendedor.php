<?php

// Dashboard
Route::get('/dashboard', function () {
    /*$users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();*/

    //dd($users);
    $dt = Carbon\Carbon::now();

    $clientes = App\Client::all()->where('vendedor_id', Auth::id());
    $birthdays = $clientes->filter(function($cliente,$key){
        return Carbon\Carbon::parse($cliente->birthday)->isBirthday(Carbon\Carbon::now());
    });

    $ordenes = App\Order::all()->where('vendedor_id', Auth::id());
    $recoger = $ordenes->where('recoger','1');
    return view('vendedor.dashboard', compact('ordenes','birthdays','recoger','clientes'));
})->name('dashboard');

// Clientes
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
Route::get('/ordenes/{order}/pdf','Vendedor\OrderController@orderpdf');

// Events
Route::get('/citas','Vendedor\EventController@index');
Route::get('/citas/agregar','Vendedor\EventController@create');
Route::post('/citas','Vendedor\EventController@store');
Route::get('/citas/{cita}','Vendedor\EventController@show');
Route::get('/citas/{cita}/editar','Vendedor\EventController@edit');
Route::put('/citas/{cita}','Vendedor\EventController@update');

// Profile
Route::get('/perfil','Vendedor\ProfileController@index');
Route::get('/perfil/solicitarCambio', 'Vendedor\ProfileController@askDataChange');

Route::get('/pruebamail', function() {
    return view('mails.action',[
        'asunto' => 'Pedido #23 Aprobado.',
        'urlAccion' => '/vendedor/ordenes/1',
        'cuerpo' => 'El pedido ahora se encuentra aprobado, en 24 horas deberá ingresar a producción y posteriormente podrás recogerlo en las instalaciones de Privanza. Si deseas más información puedes consultarla haciendo click en el siguiente botón:'
    ]);
});
