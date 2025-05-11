<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::apiResource('orders', OrderController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('orders/{order}/pay', [PaymentController::class, 'pay']);
});
