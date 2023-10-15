<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\KaryawanController;
use App\Http\Controllers\Master\LokasiController;
use App\Http\Controllers\Master\PelangganController;
use App\Http\Controllers\Master\PosisiController;
use App\Http\Controllers\Master\RakController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\Transaksi\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route Master Data
Route::apiResource('/karyawan', KaryawanController::class);
Route::apiResource('/rak', RakController::class);
Route::apiResource('/lokasi', LokasiController::class);
Route::apiResource('/barang', BarangController::class);
Route::apiResource('/pelanggan', PelangganController::class);
Route::apiResource('/posisi', PosisiController::class);



Route::post('/login', [AuthController::class,'login']);

// Jwt Middleware
Route::middleware('jwt.verify')->group(function(){
    Route::get('/mycredentials',[AuthController::class,'getAuthenticatedUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/user', UserController::class);

    // Route Transaksi
    Route::controller(TransaksiController::class)->group(function (){
        Route::post('/transaksi', 'store');
        Route::put('/transaksi/{transaksi}', 'update');
        Route::delete('/transaksi/{transaksi}', 'destroy');
        Route::get('/transaksi/{transaksi}', 'show');
    });

    // Detail Transaksi
    Route::controller(DetailTransaksiController::class)->group(function (){
        Route::post('/detail_transaksi', 'store');
        Route::delete('/detail_transaksi/transaksi/{id}', 'destoryByTransaksiId');
        Route::delete('/detail_transaksi/id/{id}', 'destroy');
    });
});
