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


Route::middleware(['auth'])->group(function () {
    // main
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::middleware(['permission'])->group(function () {
        // rutas roles
        Route::get('/roles/lista', 'RolesController@index');
        Route::get('/roles/nuevo', 'RolesController@create');
        Route::post('/roles/nuevo', 'RolesController@store')->name('nuevo-rol');
        Route::get('/roles/editar/{id}', 'RolesController@edit');
        Route::put('/roles/{id}', 'RolesController@update')->name('editar-rol');
        Route::delete('/roles/{id}', 'RolesController@destroy')->name('delete-rol');

        // rutas usuarios
        Route::get('/usuarios/lista', 'UsersController@index');
        Route::get('/usuarios/nuevo', 'UsersController@create');
        Route::post('/usuarios/nuevo', 'UsersController@store')->name('nuevo-usuario');
        Route::get('/usuarios/editar/{id}', 'UsersController@edit');
        Route::put('/usuarios/{id}', 'UsersController@update')->name('editar-usuario');
        Route::get('/usuarios/{id}', 'UsersController@show');
        Route::delete('/usuarios/{id}', 'UsersController@destroy')->name('delete-user');
        Route::get('/usuarios/report/pdf', 'UsersController@reportUsers');

        // route asistencias
        Route::get('/asistencias', 'AsistenciasController@index');
        // report
        Route::get('/asistencias/pdf', 'AsistenciasController@reportPdf');

        // route personal
        Route::get('personal/lista', 'EmpleadoController@index');
        Route::get('personal/nuevo', 'EmpleadoController@create');
        Route::post('personal', 'EmpleadoController@store')->name('nuevo-personal');
        Route::get('personal/editar/{id}', 'EmpleadoController@edit');
        Route::put('personal/{id}', 'EmpleadoController@update')->name('editar-personal');
        Route::delete('personal/{id}', 'EmpleadoController@destroy')->name('eliminar-personal');
        Route::get('/personal/report/pdf', 'EmpleadoController@reportPersonal');
        Route::get('/personal/horarios', 'EmpleadoController@horariosPorCargo');

        // route horarios
        // Route::get('horarios/lista', 'HorariosController@index');
        // Route::get('horarios/nuevo', 'HorariosController@create');
        // Route::post('horarios', 'HorariosController@store')->name('nuevo-horario');
        // Route::get('horarios/editar/{id}', 'HorariosController@edit');
        // Route::put('horarios/{id}', 'HorariosController@update')->name('editar-horario');
        // Route::delete('horarios/{id}', 'HorariosController@destroy')->name('eliminar-horario');
        // Route::get('/horarios/report/pdf', 'HorariosController@reportHorarios');

        // route cargos
        Route::get('cargos/lista', 'CargosController@index');
        Route::get('cargos/nuevo', 'CargosController@create');
        Route::post('cargos', 'CargosController@store')->name('nuevo-cargo');
        Route::get('cargos/editar/{id}', 'CargosController@edit');
        Route::put('cargos/{id}', 'CargosController@update')->name('editar-cargo');
        Route::delete('cargos/{id}', 'CargosController@destroy')->name('eliminar-cargo');
        Route::get('/cargos/report/pdf', 'CargosController@reportCargos');

    });
    
    // route nomina
    // Route::get('/nomina', 'NominaController@index');
    // Route::get('/nomina-pdf', 'NominaController@reportNomina');
});

Route::get('marcar-asistencia', 'MiAsistenciaController@index');
Route::post('marcar', 'MiAsistenciaController@mainMarcar')->name('marcar');
