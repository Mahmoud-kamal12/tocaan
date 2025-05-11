<?php

namespace App\Services\Payments\Interfaces;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function pay(Order $order): array;
}
