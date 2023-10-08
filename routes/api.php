<?php

use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\KaryawanController;
use App\Http\Controllers\Master\LokasiController;
use App\Http\Controllers\Master\PelangganController;
use App\Http\Controllers\Master\RakController;
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

Route::apiResource('/karyawan', KaryawanController::class);
Route::apiResource('/rak', RakController::class);
Route::apiResource('/lokasi', LokasiController::class);
Route::apiResource('/barang', BarangController::class);
Route::apiResource('/pelanggan', PelangganController::class);
