<?php

use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ListaCompraController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\FacturaController;


use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

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
    return view('welcome');
});


Route::resource('productos', ProductoController::class);
Route::get('/buscar-productos', [App\Http\Controllers\ProductoController::class, 'buscar'])->name('productos.buscar');

Route::resource('ventas', VentaController::class);
Route::post('/ventas/rapida', [VentaController::class, 'ventaRapida'])->name('ventas.rapida');

Route::resource('gastos', GastoController::class);

Route::resource('lista_compras', ListaCompraController::class);
Route::get('/buscar-lista-compras', [App\Http\Controllers\ListaCompraController::class, 'buscar'])->name('lista_compras.buscar');

Route::get('/reiniciar-presupuesto', [PresupuestoController::class, 'reiniciarPresupuesto'])->name('presupuesto.reiniciar');

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');

Route::resource('pedidos', PedidoController::class);
Route::get('productos/search/', [ProductoController::class, 'search'])->name('productos.search');

Route::prefix('productos')->group(function () {
    Route::post('buscar-producto-existente', [BusquedaController::class, 'buscarProductoExistente'])->name('buscarProductoExistente');
});

Route::resource('facturas', FacturaController::class);
