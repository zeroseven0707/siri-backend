<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function findById(string $id): ?Order
    {
        return Order::with(['user', 'driver', 'assignedDriver', 'service', 'foodItems.foodItem'])->find($id);
    }

    public function getUserOrders(string $userId, ?string $status = null): LengthAwarePaginator
    {
        return Order::with(['service', 'driver', 'assignedDriver', 'foodItems.foodItem'])
            ->where('user_id', $userId)
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);
    }

    public function getAvailableOrders(): LengthAwarePaginator
    {
        return Order::with(['user', 'service'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order->fresh(['user', 'driver', 'service']);
    }
}
