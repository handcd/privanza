<?php

Route::get('/dashboard', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();

    //dd($users);

    return view('vendedor.dashboard');
})->name('dashboard');

Route::get('/ordenes', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();

    //dd($users);

    return view('vendedor.orders');
})->name('ordenes');

Route::get('/profile', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();

    //dd($users);

    return view('vendedor.profile');
})->name('profile');

