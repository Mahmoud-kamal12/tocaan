<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Services\Payments\Callbacks\PayPalCallbackHandler;
use App\Services\Payments\Interfaces\PaymentCallbackHandlerInterface;
use InvalidArgumentException;

class PaymentCallbackFactory
{
    public static function make(Payment $payment): PaymentCallbackHandlerInterface
    {
        return match ($payment->payment_method) {
            'paypal' => new PayPalCallbackHandler(),
            default  => throw new InvalidArgumentException("Unsupported callback for: {$payment->payment_method}"),
        };
    }
}
