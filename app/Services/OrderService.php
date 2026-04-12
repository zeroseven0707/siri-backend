<?php

namespace App\Services;

use App\Models\FoodOrderItem;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function __construct(
        private OrderRepository $orderRepo,
    ) {}

    public function createOrder(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $order = $this->orderRepo->create([
                'user_id'              => $user->id,
                'service_id'           => $data['service_id'],
                'pickup_location'      => $data['pickup_location'],
                'destination_location' => $data['destination_location'],
                'price'                => $data['price'],
                'notes'                => $data['notes'] ?? null,
                'status'               => 'pending',
            ]);

            if (!empty($data['food_items'])) {
                foreach ($data['food_items'] as $item) {
                    FoodOrderItem::create([
                        'order_id'     => $order->id,
                        'food_item_id' => $item['food_item_id'],
                        'qty'          => $item['qty'],
                        'price'        => $item['price'],
                    ]);
                }
            }

            return $this->orderRepo->findById($order->id);
        });
    }

    public function cancelOrder(User $user, Order $order): Order
    {
        if ($order->user_id !== $user->id) {
            throw ValidationException::withMessages(['order' => ['Unauthorized.']]);
        }

        if ($order->status !== 'pending') {
            throw ValidationException::withMessages(['order' => ['Order can only be cancelled while pending.']]);
        }

        // Hanya bisa cancel dalam 10 detik pertama setelah order dibuat
        if ($order->created_at->diffInSeconds(now()) > 10) {
            throw ValidationException::withMessages(['order' => ['Cancellation window has expired. Order has been accepted by the system.']]);
        }

        return $this->orderRepo->update($order, ['status' => 'cancelled']);
    }

    public function confirmOrder(User $user, Order $order): Order
    {
        if ($order->user_id !== $user->id) {
            throw ValidationException::withMessages(['order' => ['Unauthorized.']]);
        }

        if ($order->status !== 'on_progress') {
            throw ValidationException::withMessages(['order' => ['Order must be on progress to confirm receipt.']]);
        }

        return $this->orderRepo->update($order, ['status' => 'completed']);
    }

    public function acceptOrder(User $driver, Order $order): Order
    {
        if ($order->status !== 'pending') {
            throw ValidationException::withMessages(['order' => ['Order is no longer available.']]);
        }

        return $this->orderRepo->update($order, [
            'driver_id' => $driver->id,
            'status'    => 'accepted',
        ]);
    }

    public function completeOrder(User $driver, Order $order): Order
    {
        if ($order->driver_id !== $driver->id) {
            throw ValidationException::withMessages(['order' => ['Unauthorized.']]);
        }

        if ($order->status !== 'on_progress') {
            throw ValidationException::withMessages(['order' => ['Order is not in progress.']]);
        }

        return $this->orderRepo->update($order, ['status' => 'completed']);
    }
}
