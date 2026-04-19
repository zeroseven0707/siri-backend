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

    // POST /driver/location — update lokasi driver (tiap 30 detik saat on_progress)
    public function updateLocation(Request $request): JsonResponse
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $request->user()->driverProfile()->update([
            'current_lat'         => $request->latitude,
            'current_lng'         => $request->longitude,
            'location_updated_at' => now(),
        ]);

        return $this->success(null, 'Lokasi diperbarui');
    }

    // GET /driver/location/{orderId} — get lokasi driver untuk order tertentu (dipanggil user)
    public function getDriverLocation(Request $request, string $orderId): JsonResponse
    {
        $order = \App\Models\Order::find($orderId);

        if (!$order) return $this->error('Order tidak ditemukan', 404);
        if ($order->user_id !== $request->user()->id) return $this->error('Unauthorized', 403);
        if (!in_array($order->status, ['accepted', 'on_progress'])) {
            return $this->error('Driver tidak sedang aktif di pesanan ini', 422);
        }

        $driver = $order->driver;
        if (!$driver) return $this->error('Driver belum ditugaskan', 404);

        $profile = $driver->driverProfile;

        return $this->success([
            'driver' => [
                'name'            => $driver->name,
                'phone'           => $driver->phone,
                'profile_picture' => $driver->profile_picture
                    ? asset('storage/' . $driver->profile_picture)
                    : null,
                'vehicle_type'    => $profile?->vehicle_type,
                'license_plate'   => $profile?->license_plate,
            ],
            'location' => $profile?->current_lat && $profile?->current_lng ? [
                'latitude'   => (float) $profile->current_lat,
                'longitude'  => (float) $profile->current_lng,
                'updated_at' => $profile->location_updated_at?->toISOString(),
            ] : null,
        ]);
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
