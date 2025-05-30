<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'status',
        'payment_method',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
