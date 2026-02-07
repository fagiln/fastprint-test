<?php

use App\Http\Controllers\ProdukController;
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
    return view('welcome');
});

Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('produk/add', [ProdukController::class, 'view'])->name('produk.view');
Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{id}', [ProdukController::class, 'destroy'])->name('produk.delete');
Route::get('api-fetch', [ProdukController::class, 'fetchAndSaveData'])->name('api.fetch');
