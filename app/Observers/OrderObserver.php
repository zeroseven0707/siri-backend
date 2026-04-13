<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\FcmService;

class OrderObserver
{
    public function __construct(private FcmService $fcm) {}

    public function updated(Order $order): void
    {
        // Hanya kirim notif kalau status berubah
        if (!$order->wasChanged('status')) {
            return;
        }

        $order->loadMissing('user');

        if ($order->user) {
            $this->fcm->sendOrderStatusNotification($order->user, $order);
        }
    }
}
