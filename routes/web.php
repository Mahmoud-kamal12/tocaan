<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\FakePaymentController;

Route::get('/payment/callback/{paymentId}', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/fake-paypal/checkout/{token}', [FakePaymentController::class, 'checkout'])->name('fake-paypal.checkout');
