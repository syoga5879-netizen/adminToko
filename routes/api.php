<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\BookController;




// Produk routes yang dilindungi middleware sanctum auth[cite: 32]
Route::apiResource('products', ProductController::class);

// Auth routes (Publik)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/categories', [CategoryController::class, 'index']);
// Checkout: mengurangi stok produk yang terjual (Publik)
Route::post('/checkout', [CheckoutController::class, 'store']);
Route::get('/aduans', [AduanController::class, 'index']);
Route::post('/aduans', [AduanController::class, 'store']);
Route::post('/users', [AduanController::class, 'storeUser']);
// Profile & Logout routes (Dilindungi sanctum)
Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);