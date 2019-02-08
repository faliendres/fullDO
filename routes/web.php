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

    Route::delete("/usuarios/{user}", "UserController@destroy")->name('users.destroy');
    Route::get("/usuarios", "UserController@index")->name('users.index');
    Route::get("/usuarios/create", "UserController@create")->name('users.create');
    Route::get("/usuarios/{user}", "UserController@show")->name('users.show');
    Route::get("/usuarios/edit/{user}", "UserController@edit")->name('users.edit');
    Route::post("/usuarios", "UserController@store")->name('users.store');


    Route::delete("/holdings/{user}", "HoldingController@destroy")->name('holdings.destroy');
    Route::get("/holdings", "HoldingController@index")->name('holdings.index');
    Route::get("/holdings/create", "HoldingController@create")->name('holdings.create');
    Route::get("/holdings/{user}", "HoldingController@show")->name('holdings.show');
    Route::get("/holdings/edit/{user}", "HoldingController@edit")->name('holdings.edit');
    Route::post("/holdings", "HoldingController@store")->name('holdings.store');

    Route::delete("/empresas/{user}", "EmpresaController@destroy")->name('empresas.destroy');
    Route::get("/empresas", "EmpresaController@index")->name('empresas.index');
    Route::get("/empresas/create", "EmpresaController@create")->name('empresas.create');
    Route::get("/empresas/{user}", "EmpresaController@show")->name('empresas.show');
    Route::get("/empresas/edit/{user}", "EmpresaController@edit")->name('empresas.edit');
    Route::post("/empresas", "EmpresaController@store")->name('empresas.store');

    Route::delete("/gerencias/{user}", "GerenciaController@destroy")->name('gerencias.destroy');
    Route::get("/gerencias", "GerenciaController@index")->name('gerencias.index');
    Route::get("/gerencias/create", "GerenciaController@create")->name('gerencias.create');
    Route::get("/gerencias/{user}", "GerenciaController@show")->name('gerencias.show');
    Route::get("/gerencias/edit/{user}", "GerenciaController@edit")->name('gerencias.edit');
    Route::post("/gerencias", "GerenciaController@store")->name('gerencias.store');

    Route::delete("/cargos/{user}", "CargoController@destroy")->name('cargos.destroy');
    Route::get("/cargos", "CargoController@index")->name('cargos.index');
    Route::get("/cargos/create", "CargoController@create")->name('cargos.create');
    Route::get("/cargos/{user}", "CargoController@show")->name('cargos.show');
    Route::get("/cargos/edit/{user}", "CargoController@edit")->name('cargos.edit');
    Route::post("/cargos", "CargoController@store")->name('cargos.store');



    Route::get('/cargos/tree', 'CargoController@getEstructura')->name('getEstructura');
});