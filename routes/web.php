<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\HomeController;

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
    return redirect()->route('panel');
});

Auth::routes(['register' => false]);

Route::get('/panel', [HomeController::class, 'index'])->name('panel');
Route::middleware(['auth'])->group(function () {
    Route::get('/promociones', [ProductoController::class, 'promos'])->name('promos');
    Route::get('/db', [ProductoController::class, 'database'])->name('db');
    Route::get('/respaldar', [ProductoController::class, 'dbbackup'])->name('respaldar');
    Route::post('/promociones/crear', [ProductoController::class, 'nuevapromo']);
    Route::get('/costos', [HomeController::class, 'costos']);

    Route::resource('inventario', ProductoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('ventas', VentaController::class);
});
