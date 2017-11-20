<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('vendedor')->user();

    //dd($users);

    return view('vendedor.home');
})->name('home');

