<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfitController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.databarang');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::post('/import-barang-excel', [BarangController::class, 'importExcel'])->name('import-barang-excel');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/barang/edit{id}', [BarangController::class, 'edit'])->name('barang.editbarang');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');

    // Transaksi Routes
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.indextransaksi');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('hutang', [TransaksiController::class, 'hutang'])->name('transaksi.hutang');
    Route::get('hutang/{pelanggan}', [TransaksiController::class, 'transaksiPelanggan'])->name('transaksi.detailhutang');
    Route::put('hutang/{transaksi}/update-status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

    Route::get('/profit', [ProfitController::class, 'index'])->name('profit.profit');
    Route::get('/profit/filter', [ProfitController::class, 'filter'])->name('profit.filter');
});

require __DIR__ . '/auth.php';
