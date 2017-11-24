<?php

Route::get('/dashboard', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('validador')->user();

    //dd($users);

    return view('validador.dashboard');
})->name('dashboard');

