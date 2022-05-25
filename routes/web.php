<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;

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

Route::get('/panel', [App\Http\Controllers\HomeController::class, 'index'])->name('panel');
Route::middleware(['auth'])->group(function () {
    Route::get('/promociones', [App\Http\Controllers\ProductoController::class, 'promos'])->name('promos');
    Route::get('/db', [App\Http\Controllers\ProductoController::class, 'database'])->name('db');
    Route::get('/respaldar', [App\Http\Controllers\ProductoController::class, 'dbbackup'])->name('respaldar');
    Route::post('/promociones/crear', [App\Http\Controllers\ProductoController::class, 'nuevapromo']);

    Route::resource('inventario', ProductoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('ventas', VentaController::class);
});
