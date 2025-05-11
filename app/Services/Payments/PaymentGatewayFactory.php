<?php

namespace App\Services\Payments;

use App\Services\Payments\Gateways\PayPalGateway;
use App\Services\Payments\Interfaces\PaymentGatewayInterface;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    public static function make(string $method): PaymentGatewayInterface
    {
        return match ($method) {
            'paypal' => new PayPalGateway(),
            default  => throw new InvalidArgumentException("Unsupported payment method: {$method}")
        };
    }
}
