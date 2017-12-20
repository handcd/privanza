<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vendedor', function() {
  return redirect('/vendedor/login');
});

Route::get('/admin', function(){
  return redirect('/admin/login');
});

Route::get('/validador', function () {
  return redirect('/validador/login');
});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});


Route::group(['prefix' => 'validador'], function () {
  Route::get('/login', 'ValidadorAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'ValidadorAuth\LoginController@login');
  Route::post('/logout', 'ValidadorAuth\LoginController@logout')->name('logout');

  //Route::get('/register', 'ValidadorAuth\RegisterController@showRegistrationForm')->name('register');
  //Route::post('/register', 'ValidadorAuth\RegisterController@register');

  Route::post('/password/email', 'ValidadorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'ValidadorAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'ValidadorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'ValidadorAuth\ResetPasswordController@showResetForm');
});

Route::group(['prefix' => 'vendedor'], function () {
  Route::get('/login', 'VendedorAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'VendedorAuth\LoginController@login');
  Route::post('/logout', 'VendedorAuth\LoginController@logout')->name('logout');

  //Route::get('/register', 'VendedorAuth\RegisterController@showRegistrationForm')->name('register');
  //Route::post('/register', 'VendedorAuth\RegisterController@register');

  Route::post('/password/email', 'VendedorAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'VendedorAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'VendedorAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'VendedorAuth\ResetPasswordController@showResetForm');
});
