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
        Route::post('personal', 'EmpleadoController@store')->name('nuevo-personal');
        Route::get('personal/editar/{id}', 'EmpleadoController@edit');
        Route::put('personal/{id}', 'EmpleadoController@update')->name('editar-personal');
        Route::delete('personal/{id}', 'EmpleadoController@destroy');

        // route cargos
        Route::get('cargos/lista', 'CargosController@index');
        Route::get('cargos/nuevo', 'CargosController@create');
        Route::post('cargos', 'CargosController@store')->name('nuevo-cargo');
        Route::get('cargos/editar/{id}', 'CargosController@edit');
        Route::put('cargos/{id}', 'CargosController@update')->name('editar-cargo');
        Route::delete('cargos/{id}', 'CargosController@destroy')->name('eliminar-cargo');

        // route horarios
        Route::get('horarios/lista', 'HorariosController@index');
        Route::get('horarios/nuevo', 'HorariosController@create');
        Route::post('horarios', 'HorariosController@store')->name('nuevo-horario');
        Route::get('horarios/editar/{id}', 'HorariosController@edit');
        Route::put('horarios/{id}', 'HorariosController@update')->name('editar-horario');
        Route::delete('horarios/{id}', 'HorariosController@destroy')->name('eliminar-horario');
    });
});
