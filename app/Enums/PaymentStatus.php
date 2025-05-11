<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = 0;
    case SUCCESSFUL = 1;
    case FAILED = 2;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::SUCCESSFUL => 'Successful',
            self::FAILED => 'Failed',
        };
    }
}
