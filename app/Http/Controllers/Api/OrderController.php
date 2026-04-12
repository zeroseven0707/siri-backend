<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(
        private OrderService $orderService,
        private OrderRepository $orderRepo,
    ) {}

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->user(), $request->validated());

        return $this->success(new OrderResource($order), 'Order created', 201);
    }

    public function index(Request $request): JsonResponse
    {
        $orders = $this->orderRepo->getUserOrders($request->user()->id);

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

    public function show(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        // Users can only see their own orders; drivers can see orders assigned to them
        if ($request->user()->isUser() && $order->user_id !== $request->user()->id) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success(new OrderResource($order));
    }

    public function cancel(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->cancelOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order cancelled');
    }

    // User konfirmasi pesanan sudah diterima (on_progress → completed)
    public function confirm(Request $request, string $id): JsonResponse
    {
        $order = $this->orderRepo->findById($id);

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        $order = $this->orderService->confirmOrder($request->user(), $order);

        return $this->success(new OrderResource($order), 'Order confirmed as received');
    }
}
