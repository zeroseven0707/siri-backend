<?php

namespace App\Services;

use App\Models\PushNotification;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    private string $fcmUrl = 'https://fcm.googleapis.com/v1/projects/{project_id}/messages:send';

    /**
     * Kirim notifikasi ke semua token berdasarkan target.
     * Menggunakan FCM HTTP v1 API dengan OAuth2 Bearer token.
     */
    public function broadcast(PushNotification $notification): int
    {
        $query = User::whereNotNull('fcm_token');

        if ($notification->target !== 'all') {
            $query->where('role', $notification->target);
        } else {
            $query->whereIn('role', ['user', 'driver']);
        }

        $tokens = $query->pluck('fcm_token')->filter()->values();

        if ($tokens->isEmpty()) {
            return 0;
        }

        $sent = 0;

        // FCM v1 kirim per token (atau pakai multicast untuk batch)
        foreach ($tokens->chunk(500) as $chunk) {
            foreach ($chunk as $token) {
                $success = $this->sendToToken($token, $notification);
                if ($success) $sent++;
            }
        }

        return $sent;
    }

    private function sendToToken(string $token, PushNotification $notification): bool
    {
        // Gunakan server key dari .env (FCM Legacy HTTP API)
        // Untuk produksi gunakan FCM v1 dengan service account
        $serverKey = config('services.fcm.server_key');

        if (!$serverKey) {
            Log::warning('FCM server key not configured');
            return false;
        }

        $payload = [
            'to' => $token,
            'notification' => [
                'title' => $notification->title,
                'body'  => $notification->body,
                'image' => $notification->image,
            ],
            'data' => array_merge(
                $notification->data ?? [],
                [
                    'notification_id' => $notification->id,
                    'type'            => $notification->type,
                ]
            ),
            'priority' => 'high',
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => "key={$serverKey}",
                'Content-Type'  => 'application/json',
            ])->post('https://fcm.googleapis.com/fcm/send', $payload);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('FCM send failed: ' . $e->getMessage());
            return false;
        }
    }
}
