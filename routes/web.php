<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PenjualanController;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

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
    $terjual = Penjualan::all()->count();
    $barang = Barang::all()->count();
    return view('dashboard', compact('terjual', 'barang'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('barang', BarangController::class);
    Route::resource('penjualan', PenjualanController::class);

    // Routes for Keranjang (Cart) functionalities
    Route::post('keranjang', [KeranjangController::class, 'store']);
    Route::get('keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::delete('keranjang/{id}', [KeranjangController::class, 'destroy']);

    // Route for Penjualan (Sales) functionalities
    Route::post('penjualan/checkout', [PenjualanController::class, 'checkout']);

    Route::get('history-penjualan', [PenjualanController::class, 'history'])->name('history-penjualan');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
