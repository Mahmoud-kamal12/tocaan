<?php

namespace App\Http\Controllers\Api;

use App\Helpers\WebResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Services\Payments\PaymentCallbackFactory;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Enums\OrderStatus;
use App\Services\Payments\PaymentGatewayFactory;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function pay(StorePaymentRequest  $request, $orderId): JsonResponse
    {
        $order = Order::with('payments')->findOrFail($orderId);

        if ($order->user_id !== auth()->id()) {
            return ApiResponse::error('Unauthorized', 403);
        }

        if ($order->status !== OrderStatus::CONFIRMED->value) {
            return ApiResponse::error('Only confirmed orders can be paid for.', 422);
        }

        $gateway = PaymentGatewayFactory::make($request->payment_method);
        $result = $gateway->pay($order);

        $payment = Payment::create([
            'order_id' => $order->id,
            'payment_id' => $result['payment_id'],
            'status' => $result['status'],
            'payment_method' => $request->payment_method
        ]);

        return ApiResponse::success([
            'payment' => new PaymentResource($payment),
            'redirect_to' => $result['checkout_url']
        ], $result['message']);
    }

    public function callback(Request $request, string $paymentId): Response
    {
        $payment = Payment::where('payment_id', $paymentId)->firstOrFail();

        $handler = PaymentCallbackFactory::make($payment);

        try {
            $handler->handle($request, $payment);
            return WebResponse::renderMessage('Callback Handled', 'Payment status updated successfully.');
        } catch (\Throwable $e) {
            return WebResponse::renderMessage('Callback Error', 'An error occurred during payment handling.', 500);
        }
    }
}
