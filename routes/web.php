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
    if (auth()->guest())
        return view('auth.login');
    return redirect()->route("home");
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('profile', function () {
        return view('profile');
    })->name("profile");

    Route::get('/home', 'HomeController@index')->name('home');

    Route::delete("/users/{user}", "UserController@destroy")->name('users.destroy');
    Route::get("/users", "UserController@index")->name('users.index');
    Route::get("/users/create", "UserController@create")->name('users.create');
    Route::get("/users/{user}", "UserController@show")->name('users.show');
    Route::get("/users/edit/{user}", "UserController@edit")->name('users.edit');
    Route::post("/users", "UserController@store")->name('users.store');

    Route::get('/cargos', 'CargoController@getEstructura')->name('getEstructura');
});