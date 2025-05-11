<?php

namespace App\Services\Payments\Gateways;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Services\Payments\Interfaces\PaymentGatewayInterface;

class PayPalGateway implements PaymentGatewayInterface
{
    public function pay(Order $order): array
    {
        $token = uniqid('checkout_');
        $url = url("/fake-paypal/checkout/{$token}");

        cache()->put($token, [
            'order_id' => $order->id,
            'payment_method' => 'paypal',
        ], 300);

        return [
            'status' => PaymentStatus::PENDING->value,
            'payment_id' => $token,
            'message' => 'Redirecting to PayPal...',
            'checkout_url' => $url
        ];
    }
}
