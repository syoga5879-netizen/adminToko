<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;


// Produk routes yang dilindungi middleware sanctum auth[cite: 32]
Route::apiResource('products', ProductController::class);

// Auth routes (Publik)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/aduans', [AduanController::class, 'index']);
Route::post('/aduans', [AduanController::class, 'store']);
Route::post('/users', [AduanController::class, 'storeUser']);
// Profile & Logout routes (Dilindungi sanctum)
Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});