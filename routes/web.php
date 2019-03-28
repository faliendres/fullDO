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
Route::group(['middleware' => ['auth','check.unread']], function () {
    Route::get('profile', function () {
        return view('profile');
    })->name("profile");
    Route::get("/perfil", "UserController@profile")->middleware("save-back")->name('perfil');
    Route::get('/home', 'HomeController@index')->middleware("save-back")->name('home');

Route::group(['middleware' => ['auth','check.permission','save-back']], function () {
    

    Route::delete("/usuarios/{id}", "UserController@destroy")->name('users.destroy');
    Route::get("/usuarios", "UserController@index")->name('users.index');
    Route::get("/usuarios/create", "UserController@create")->name('users.create');
    Route::get("/usuarios/{id}", "UserController@show")->name('users.show');
    Route::put("/usuarios/{id}", "UserController@update")->name('users.update');
    Route::get("/usuarios/edit/{id}", "UserController@edit")->name('users.edit');
    Route::post("/usuarios", "UserController@store")->name('users.store');
    Route::post("/usuarios/changepassword", "UserController@changepassword")->name('users.changepassword');

    Route::delete("/holdings/{id}", "HoldingController@destroy")->name('holdings.destroy');
    Route::get("/holdings", "HoldingController@index")->name('holdings.index');
    Route::get("/holdings/create", "HoldingController@create")->name('holdings.create');
    Route::get("/holdings/{id}", "HoldingController@show")->name('holdings.show');
    Route::put("/holdings/{id}", "HoldingController@update")->name('holdings.update');
    Route::get("/holdings/edit/{id}", "HoldingController@edit")->name('holdings.edit');
    Route::post("/holdings", "HoldingController@store")->name('holdings.store');
    Route::get('/holdings/{holding}/empresas', 'HoldingController@getEmpresasByHolding')->name('getEmpresasByHolding');

    Route::delete("/empresas/{id}", "EmpresaController@destroy")->name('empresas.destroy');
    Route::get("/empresas", "EmpresaController@index")->name('empresas.index');
    Route::get("/empresas/create", "EmpresaController@create")->name('empresas.create');
    Route::get("/empresas/{id}", "EmpresaController@show")->name('empresas.show');
    Route::put("/empresas/{id}", "EmpresaController@update")->name('empresas.update');
    Route::get("/empresas/edit/{id}", "EmpresaController@edit")->name('empresas.edit');
    Route::post("/empresas", "EmpresaController@store")->name('empresas.store');
    Route::get('/empresas/{empresa}/gerencias', 'EmpresaController@getGerenciasbyEmpresa')->name('getGerenciasbyEmpresa');

    Route::delete("/gerencias/{id}", "GerenciaController@destroy")->name('gerencias.destroy');
    Route::get("/gerencias", "GerenciaController@index")->name('gerencias.index');
    Route::get("/gerencias/create", "GerenciaController@create")->name('gerencias.create');
    Route::get("/gerencias/{id}", "GerenciaController@show")->name('gerencias.show');
    Route::put("/gerencias/{id}", "GerenciaController@update")->name('gerencias.update');
    Route::get("/gerencias/edit/{id}", "GerenciaController@edit")->name('gerencias.edit');
    Route::post("/gerencias", "GerenciaController@store")->name('gerencias.store');

    Route::get('/organigrama', 'HomeController@organigrama')->name('organigrama');
    Route::get('/organigrama/tree', 'CargoController@getEstructura')->name('getEstructura');

    Route::delete("/cargos/{id}", "CargoController@destroy")->name('cargos.destroy');
    Route::get("/cargos", "CargoController@index")->name('cargos.index');
    Route::get("/cargos/create", "CargoController@create")->name('cargos.create');
    Route::get("/cargos/{id}", "CargoController@show")->name('cargos.show');
    Route::put("/cargos/{id}", "CargoController@update")->name('cargos.update');
    Route::get("/cargos/edit/{id}", "CargoController@edit")->name('cargos.edit');
    Route::post("/cargos", "CargoController@store")->name('cargos.store');

    Route::delete("/solicitudes/{id}", "SolicitudController@destroy")->name('solicitudes.destroy');
    Route::get("/solicitudes", "SolicitudController@index")->name('solicitudes.index');
    Route::get("/solicitudes/buzon", "SolicitudController@index")->name('solicitudes.buzon');
    Route::get("/solicitudes/create", "SolicitudController@create")->name('solicitudes.create');
    Route::get("/solicitudes/{id}", "SolicitudController@show")->name('solicitudes.show');
    Route::put("/solicitudes/{id}", "SolicitudController@update")->name('solicitudes.update');
    Route::get("/solicitudes/edit/{id}", "SolicitudController@edit")->name('solicitudes.edit');
    Route::post("/solicitudes", "SolicitudController@store")->name('solicitudes.store');
});

});
