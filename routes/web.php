<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeconomicaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest', 'nocache', 'logout.if.authenticated')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'CheckAdmin'])->group(function () {
    
    Route::controller(AdministracionController::class)->group(function () {
        Route::get('administracion.usuarios.index', 'index')->name('adminIndex'); 
        Route::delete('administracion.usuarios.index/{id}', 'destroy')->name('admineli');
        Route::get('administracion.usuarios.edit/{id}', 'edit')->name('adminedi');    
        Route::patch('administracion.usuarios.update/{id}','update')->name('adminedi.update');   
    });
    Route::controller(CarreraController::class)->group(function () {
        Route::get('administracion.carreras.index', 'index')->name('adminCarrera');  
        Route::get('administracion.carreras.nuevo', 'create')->name('CarreraNueva');
        Route::post('administracion.carreras.store', 'store')->name('storeCarrera'); 
        Route::delete('administracion.carreras.index/{id}', 'destroy')->name('eliCarrera');  
        Route::get('administracion.carreras.edit/{id}', 'edit')->name('modifCarrera');
        Route::patch('administracion.carreras.update/{id}','update')->name('updateCarrera');

        Route::get('administracion.usuarios.index/{id}', 'asignar')->name('asigCarr');        

        Route::post('administracion.usuarios.asignar/{carrera}', 'asignarUsuarioCarrera')->name('asignarUsuarioCarrera');
        Route::delete('administracion.usuarios.eliminar/{carrera}/{usuario}', 'eliminarUsuarioCarrera')->name('eliminarUsuarioCarrera');   
    });
    Route::controller(TeconomicaController::class)->group(function () {
        Route::get('administracion.peconomica.index', 'index')->name('teconomicaCarrera');  
       
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
