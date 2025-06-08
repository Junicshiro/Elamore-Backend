<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\ContactController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::put('/user/{id}', [AuthController::class, 'update']);


Route::get('/users', [UserController::class, 'index']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::post('/favorites', [FavoriteController::class, 'store']);
Route::get('/favorites/{user_id}', [FavoriteController::class, 'index']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);
Route::get('/favorites/{user_id}', [FavoriteController::class, 'getByUser']);

Route::post('/cart', [CartController::class, 'store']);
Route::get('/cart/{user_id}', [CartController::class, 'index']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);

Route::post('/checkout', [OrderController::class, 'store']);
Route::get('/orders/{user_id}', [OrderController::class, 'getByUser']);

Route::get('/orders', [OrderController::class, 'all']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

Route::get('/admin/summary', [DashboardController::class, 'summary']);

Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/contact', [ContactController::class, 'send']);