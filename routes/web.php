<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
    // return view('welcome');
});

Auth::routes();
Route::get('register', function () {
    return redirect('/');
});

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    /**
     * admin
     */
    Route::middleware(['role:super'])->group(function () {

    });
    /**
     * user
     */
    Route::middleware(['role:admin'])->group(function () {

    });
    /**
     * both
     */
    Route::middleware(['role:super,admin'])->group(function () {
        // route personal
        Route::get('personal/lista', 'EmpleadoController@index');
        Route::get('personal/nuevo', 'EmpleadoController@create');

        // route cargos
        Route::get('cargos/lista', 'CargosController@index');
    });
});
