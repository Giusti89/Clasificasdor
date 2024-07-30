<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PeconomicaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicoController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\TeconomicaController;
use App\Models\Requerimiento;
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
    return view('docentes.menu.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'CheckAdmin'])->group(function () {
    
    Route::controller(AdministracionController::class)->group(function () {
        Route::get('administracion.usuarios.index', 'index')->name('adminIndex'); 
        Route::delete('administracion.usuarios.index/{id}', 'destroy')->name('admineli');
        Route::get('administracion.usuarios.edit/{id}', 'edit')->name('adminedi');    
        Route::patch('administracion.usuarios.update/{id}','update')->name('adminedi.update');   
    });
    
    Route::controller(EstadisticasController::class)->group(function () {
        Route::get('estadisticas.index', 'index')->name('estadisticaIndex'); 
        Route::get('estadisticas.clasificados', 'clasificados')->name('estadisticaClasificados');
        // Route::get('administracion.usuarios.edit/{id}', 'edit')->name('adminedi');    
        // Route::patch('administracion.usuarios.update/{id}','update')->name('adminedi.update');   
    });

    Route::controller(CarreraController::class)->group(function () {
        Route::get('administracion.carreras.index', 'index')->name('adminCarrera');  
        Route::get('administracion.carreras.nuevo', 'create')->name('CarreraNueva');
        Route::post('administracion.carreras.store', 'store')->name('storeCarrera'); 
        Route::delete('administracion.carreras.index/{id}', 'destroy')->name('eliCarrera');  
        Route::get('administracion.carreras.edit/{id}', 'edit')->name('modifCarrera');
        Route::patch('administracion.carreras.update/{id}','update')->name('updateCarrera');

        Route::get('administracion.carreras.index/{id}', 'asignar')->name('asigCarr');        

        Route::post('administracion.usuarios.asignar/{carrera}', 'asignarUsuarioCarrera')->name('asignarUsuarioCarrera');
        Route::delete('administracion.usuarios.eliminar/{carrera}/{usuario}', 'eliminarUsuarioCarrera')->name('eliminarUsuarioCarrera');   
    });

    Route::controller(TeconomicaController::class)->group(function () {
        Route::get('administracion.peconomica.index', 'index')->name('teconomicaCarrera'); 
        Route::get('administracion.peconomica.nuevo', 'create')->name('TeconoNueva'); 
        Route::post('administracion.peconomica.store', 'store')->name('storeTecono'); 
        Route::get('administracion.peconomica.edit/{id}', 'edit')->name('editTeco');
        Route::patch('administracion.peconomica.update/{id}', 'update')->name('updateTeco');
        Route::delete('administracion.peconomica.index/{id}', 'destroy')->name('eliTeco');         
    });
    
    Route::controller(PeconomicaController::class)->group(function () {
        Route::get('administracion.subeconomicas.index/{id}', 'create')->name('subparIndex');         
        Route::post('administracion.subeconomicas.store/{id}', 'store')->name('storeSubecono'); 
        Route::delete('administracion.subeconomicas.index/{id}', 'destroy')->name('eliSubeco');     
        Route::get('administracion.subeconomicas.edit/{id}', 'edit')->name('editSubeco');
        Route::patch('administracion.subeconomicas.update/{id}', 'update')->name('updateSubeco');
    });

    Route::controller(ItemController::class)->group(function () {      
        Route::get('item.aprobado/{id}', 'aprobado')->name('calsificarReque');
        Route::get('item.clasificar/{id}', 'clasificar')->name('calsifPartida');
        Route::post('item.clasificar', 'ejecutar')->name('itemEjecutar');

    });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(PublicoController::class)->group(function () {
        Route::get('docentes.menu.index', 'index')->name('publicoIndex');
        Route::get('docentes.menu.ver/{id}', 'ver')->name('verIndex');
        Route::get('docentes.menu.pdf/{id}', 'pgenerarPpdf')->name('verpdf');
    });

    Route::controller(RequerimientoController::class)->group(function () {
        Route::get('docentes.pedidos.index', 'create')->name('solicitudCreate');
        Route::post('docentes.pedidos.store', 'store')->name('storeSolicitud');
        Route::get('docentes.pedidos.edit/{id}', 'edit')->name('editSolicitud');
        Route::patch('docentes.pedidos.update/{id}', 'update')->name('updateSolicitud');
        Route::delete('docentes.pedidos.destroy/{id}', 'destroy')->name('destroySolicitud');
    });

    Route::controller(ItemController::class)->group(function () {
        Route::get('item.index/{id}', 'index')->name('llenarSolicitud');
        Route::post('item.index/{id}', 'store')->name('storeLlenar');
        Route::get('item.edit/{id}', 'edit')->name('editItem');
        Route::patch('item.update/{id}', 'update')->name('updateItem');
        Route::delete('item.destroy/{id}', 'destroy')->name('destroyLlenar'); 
        
        Route::get('item.listo/{id}', 'listo')->name('listoLlenar');        
        
        Route::get('item.vlisto/{id}', 'vista')->name('vistallenarSol');
        Route::post('item.aprobar/{id}', 'aprobar')->name('aprobarLlenar');

        Route::post('item.aprobar/{id}', 'alta')->name('altaReque');

        Route::get('item.observacion/{id}', 'vobservacion')->name('vistaobservacion');
        Route::post('item.observacion/{id}', 'storeObservacion')->name('storeobservacion');

        Route::get('item.correccion/{id}', 'vcorreccion')->name('vistacorreccion');
        Route::post('item.correccion/{id}', 'storecorreccion')->name('storecorrec');


    });



});

require __DIR__.'/auth.php';
