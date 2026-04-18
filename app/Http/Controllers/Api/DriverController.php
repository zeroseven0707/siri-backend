<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use ApiResponse;

    public function __construct(
        private OrderService $orderService,
        private OrderRepository $orderRepo,
    ) {}

    public function availableOrders(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $orders = $this->orderRepo->getDriverOrders($request->user()->id, $status);

        return $this->success([
            'orders'     => OrderResource::collection($orders),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page'    => $orders->lastPage(),
                'per_page'     => $orders->perPage(),
                'total'        => $orders->total(),
            ],
        ]);
    }

    // POST /driver/toggle-active — toggle is_active
    public function toggleActive(Request $request): JsonResponse
    {
        $user = $request->user();
        $newState = !$user->is_active;
        $user->update(['is_active' => $newState]);

        return $this->success(
            ['is_active' => $newState],
            $newState ? 'Driver diaktifkan' : 'Driver dinonaktifkan'
        );
    }

    public function acceptOrder(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->acceptOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order accepted');
    }

    public function pickupOrder(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->pickupOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order picked up');
    }

    public function processOrder(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->processOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order is now in progress');
    }

    public function completeOrder(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->completeOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order completed');
    }
}
