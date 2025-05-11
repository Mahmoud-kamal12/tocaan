<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;


Route::get('/payment/callback/{paymentId}', [PaymentController::class, 'callback']);
