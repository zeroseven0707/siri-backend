<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OsrmService
{
    private const BASE_URL = 'http://router.project-osrm.org/route/v1/driving';

    /**
     * Hitung jarak (meter) dan durasi (detik) antara dua titik koordinat.
     * Return null jika gagal.
     */
    public function getRoute(
        float $fromLat, float $fromLng,
        float $toLat,   float $toLng
    ): ?array {
        try {
            $url = sprintf(
                '%s/%s,%s;%s,%s?overview=false',
                self::BASE_URL,
                $fromLng, $fromLat,  // OSRM: longitude dulu, baru latitude
                $toLng,   $toLat
            );

            $response = Http::timeout(8)->get($url);

            if (!$response->ok()) {
                Log::warning('OSRM non-200', ['status' => $response->status()]);
                return null;
            }

            $data = $response->json();

            if (($data['code'] ?? '') !== 'Ok' || empty($data['routes'])) {
                return null;
            }

            $route = $data['routes'][0];

            return [
                'distance_meters'  => (int) round($route['distance']),
                'duration_seconds' => (int) round($route['duration']),
                'distance_km'      => round($route['distance'] / 1000, 2),
                'duration_minutes' => round($route['duration'] / 60, 1),
            ];
        } catch (\Throwable $e) {
            Log::warning('OSRM error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Hitung ongkir berdasarkan jarak.
     * Base fee + per-km fee, minimum Rp 5.000.
     */
    public function calculateDeliveryFee(float $distanceKm): int
    {
        $baseFee   = 5000;   // Rp 5.000 untuk 0-2 km pertama
        $perKmFee  = 2500;   // Rp 2.500 per km setelah 2 km
        $freeKm    = 2.0;

        if ($distanceKm <= $freeKm) {
            return $baseFee;
        }

        $extraKm = $distanceKm - $freeKm;
        $fee     = $baseFee + (int) ceil($extraKm) * $perKmFee;

        // Bulatkan ke ribuan terdekat
        return (int) (ceil($fee / 1000) * 1000);
    }
}
