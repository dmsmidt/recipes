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

// Authentication Routes...
$this->get('login', '\App\Admin\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
$this->post('login', '\App\Admin\Http\Controllers\Auth\LoginController@login');
$this->post('logout', '\App\Admin\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', '\App\Admin\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', '\App\Admin\Http\Controllers\Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', '\App\Admin\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', '\App\Admin\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', '\App\Admin\Http\Controllers\Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', '\App\Admin\Http\Controllers\Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index');
