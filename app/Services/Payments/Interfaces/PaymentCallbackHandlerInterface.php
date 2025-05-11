<?php

namespace App\Services\Payments\Interfaces;

use Illuminate\Http\Request;
use App\Models\Payment;

interface PaymentCallbackHandlerInterface
{
    public function handle(Request $request, Payment $payment): void;
}
