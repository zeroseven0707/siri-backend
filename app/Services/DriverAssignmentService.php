<?php

namespace App\Services;

use App\Models\DriverProfile;
use App\Models\Order;
use App\Models\User;

class DriverAssignmentService
{
    /**
     * Pilih driver kandidat dan simpan ke assigned_driver_id.
     * Status order tetap 'pending' — belum accepted.
     * Driver resmi di-assign saat user confirm (lewat confirmOrder).
     */
    public function assignCandidate(Order $order): ?User
    {
        $driver = $this->pickDriver($order);

        if (!$driver) {
            return null;
        }

        // Simpan kandidat driver, tapi status tetap pending
        $order->update(['assigned_driver_id' => $driver->user_id]);

        // Catat waktu assignment untuk round-robin berikutnya
        $driver->update(['last_assigned_at' => now()]);

        return $driver->user;
    }

    /**
     * Resmi assign driver ke order (dipanggil saat user confirm).
     * Pindahkan assigned_driver_id → driver_id, status → accepted.
     */
    public function confirmAssignment(Order $order): void
    {
        if (!$order->assigned_driver_id) {
            // Tidak ada kandidat, coba pick ulang
            $driver = $this->pickDriver($order);
            if ($driver) {
                $order->update([
                    'driver_id'          => $driver->user_id,
                    'assigned_driver_id' => null,
                    'status'             => 'accepted',
                ]);
                $driver->update(['last_assigned_at' => now()]);
            }
            return;
        }

        $order->update([
            'driver_id'          => $order->assigned_driver_id,
            'assigned_driver_id' => null,
            'status'             => 'accepted',
        ]);
    }

    /**
     * Pilih driver dengan round-robin:
     * 1. Filter berdasarkan vehicle_type dari service (motor untuk food/ojek, mobil untuk mobil)
     * 2. Driver online + is_active yang tidak sedang menangani order aktif (free)
     * 3. Fallback: driver online + is_active dengan last_assigned_at paling lama
     */
    private function pickDriver(Order $order): ?DriverProfile
    {
        $service = $order->service;

        if (!$service) {
            return null;
        }

        // Tentukan vehicle_type berdasarkan service
        $requiredVehicleType = $service->vehicle_type ?? 'motor';

        $drivers = DriverProfile::with('user')
            ->where('vehicle_type', $requiredVehicleType)
            ->whereHas('user', fn($q) => $q->where('is_active', true))
            ->orderByRaw('last_assigned_at IS NULL DESC')
            ->orderBy('last_assigned_at', 'asc')
            ->get();

        if ($drivers->isEmpty()) {
            return null;
        }

        $activeStatuses = ['accepted', 'on_progress'];

        $freeDriver = $drivers->first(function (DriverProfile $profile) use ($activeStatuses) {
            return !Order::where('driver_id', $profile->user_id)
                ->whereIn('status', $activeStatuses)
                ->exists();
        });

        return $freeDriver ?? $drivers->first();
    }
}
