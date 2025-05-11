<?php

namespace App\Services\Payments\Callbacks;

use App\Services\Payments\Interfaces\PaymentCallbackHandlerInterface;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Enums\PaymentStatus;

class PayPalCallbackHandler implements PaymentCallbackHandlerInterface
{
    public function handle(Request $request, Payment $payment): void
    {
        $status = $request->get('status') === 'success'
            ? PaymentStatus::SUCCESSFUL->value
            : PaymentStatus::FAILED->value;

        $payment->update(['status' => $status]);
    }
}
