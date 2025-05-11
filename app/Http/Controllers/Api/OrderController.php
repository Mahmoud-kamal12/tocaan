<?php

namespace App\Http\Controllers\Api;
use App\Enums\OrderStatus;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $user = auth()->user();

        $query = $user->orders()->with('items');

        if ($request->has('status')) {
            $status = (int) $request->input('status');
            if (in_array($status, array_column(OrderStatus::cases(), 'value'))) {
                $query->where('status', $status);
            }
        }

        $orders = $query->latest()->paginate(10);

        return OrderResource::collection($orders);
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $user = auth()->user();

        $items = $request->items;

        $total = collect($items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total'   => $total,
                'status'  => OrderStatus::PENDING->value,
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_name' => $item['product_name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],
                ]);
            }

            DB::commit();

            return ApiResponse::success(
                new OrderResource($order->load('items')),
                'Order created successfully',
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Failed to create order', 500, $e->getMessage());
        }
    }

    public function update(StoreOrderRequest $request, Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return ApiResponse::error('Unauthorized', 403);
        }

        if ($order->payments()->exists()) {
            return ApiResponse::error('Cannot update order with payments', 422);
        }

        $items = $request->items;

        $total = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);

        DB::beginTransaction();
        try {
            $order->update(['total' => $total]);

            // احذف العناصر القديمة وأضف الجديدة
            $order->items()->delete();
            foreach ($items as $item) {
                $order->items()->create($item);
            }

            DB::commit();
            return ApiResponse::success(new OrderResource($order->load('items')), 'Order updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return ApiResponse::error('Update failed', 500, $e->getMessage());
        }
    }

    public function destroy(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return ApiResponse::error('Unauthorized', 403);
        }

        if ($order->payments()->exists()) {
            return ApiResponse::error('Cannot delete order with payments', 422);
        }

        $order->delete();

        return ApiResponse::success(null, 'Order deleted successfully');
    }


}
