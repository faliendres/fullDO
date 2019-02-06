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
Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});
Route::get('profile', function () {
    return view('profile');
})->name("profile");

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/cargos', 'CargoController@getEstructura')->name('getEstructura');
