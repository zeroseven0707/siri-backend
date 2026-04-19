<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OsrmService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeliveryFeeController extends Controller
{
    use ApiResponse;

    public function __construct(private OsrmService $osrm) {}

    /**
     * GET /delivery-fee
     * Query params:
     *   from_lat, from_lng  — koordinat toko / pickup
     *   to_lat,   to_lng    — koordinat user / tujuan
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'from_lat' => 'required|numeric|between:-90,90',
            'from_lng' => 'required|numeric|between:-180,180',
            'to_lat'   => 'required|numeric|between:-90,90',
            'to_lng'   => 'required|numeric|between:-180,180',
        ]);

        $route = $this->osrm->getRoute(
            (float) $request->from_lat,
            (float) $request->from_lng,
            (float) $request->to_lat,
            (float) $request->to_lng,
        );

        if (!$route) {
            // Fallback: hitung Haversine kalau OSRM gagal
            $distKm = $this->haversine(
                (float) $request->from_lat, (float) $request->from_lng,
                (float) $request->to_lat,   (float) $request->to_lng,
            );
            $route = [
                'distance_km'      => round($distKm, 2),
                'distance_meters'  => (int) ($distKm * 1000),
                'duration_minutes' => null,
                'duration_seconds' => null,
                'source'           => 'haversine_fallback',
            ];
        } else {
            $route['source'] = 'osrm';
        }

        $deliveryFee = $this->osrm->calculateDeliveryFee($route['distance_km']);

        return $this->success([
            'delivery_fee'     => $deliveryFee,
            'distance_km'      => $route['distance_km'],
            'distance_meters'  => $route['distance_meters'],
            'duration_minutes' => $route['duration_minutes'] ?? null,
            'source'           => $route['source'],
        ]);
    }

    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $R    = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
