<?php

namespace App\Http\Controllers\Api;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Enums\PaymentStatus;

class FakePaymentController extends Controller
{
    public function checkout(string $token)
    {
        $info = cache()->get($token);

        if (!$info) {
            return WebResponse::renderMessage('Invalid Session', 'This payment session is expired or invalid.', 404);
        }

        return view('layouts.fake_checkout', ['token' => $token]);
    }
}
