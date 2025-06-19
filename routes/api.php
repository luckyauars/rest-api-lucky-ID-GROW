<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\LokasiController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Route::post('/register', function (Request $request) {
//     $validator = Validator::make($request->all(), [
//         'name' => 'required|string|max:255',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:6|confirmed',
//     ]);
//     return response()->json(['message' => 'User registered successfully'], 201);
// });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/test', [MutasiController::class, 'test']);
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('mutasi', MutasiController::class);
    Route::apiResource('lokasi', LokasiController::class);
    Route::get('/mutasi/produk/{produkId}', [MutasiController::class, 'historyByProduk']);
    Route::get('/mutasi/user/{userId}', [MutasiController::class, 'historyByUser']);
});
