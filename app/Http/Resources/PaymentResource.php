<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\PaymentStatus;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'payment_id'     => $this->payment_id,
            'order_id'       => $this->order_id,
            'status'         => [
                'code'  => $this->status,
                'label' => PaymentStatus::from($this->status)->label()
            ],
            'payment_method' => $this->payment_method,
            'created_at'     => $this->created_at,
        ];
    }
}
