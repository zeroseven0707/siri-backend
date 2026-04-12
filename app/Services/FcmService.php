<?php

namespace App\Services;

use App\Models\PushNotification;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    /**
     * Kirim notifikasi ke semua token berdasarkan target.
     * Menggunakan FCM HTTP V1 API dengan Service Account OAuth2.
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

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            Log::warning('FCM: Could not get access token');
            return 0;
        }

        $sent = 0;
        foreach ($tokens as $token) {
            if ($this->sendV1($token, $notification, $accessToken)) {
                $sent++;
            }
        }

        return $sent;
    }

    /**
     * Kirim ke satu device via FCM V1 API.
     */
    private function sendV1(string $token, PushNotification $notification, string $accessToken): bool
    {
        $projectId = config('services.fcm.project_id');
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $notification->title,
                    'body'  => $notification->body,
                    'image' => $notification->image,
                ],
                'data' => array_merge(
                    array_map('strval', $notification->data ?? []),
                    [
                        'notification_id' => $notification->id,
                        'type'            => $notification->type,
                    ]
                ),
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound'        => 'default',
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                    ],
                ],
                'apns' => [
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                            'badge' => 1,
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $payload);

            if (!$response->successful()) {
                Log::warning('FCM V1 send failed', [
                    'token'    => substr($token, 0, 20) . '...',
                    'status'   => $response->status(),
                    'response' => $response->json(),
                ]);
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('FCM V1 exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Dapatkan OAuth2 access token dari service account JSON.
     */
    private function getAccessToken(): ?string
    {
        $credentialsPath = base_path(config('services.fcm.credentials'));

        if (!file_exists($credentialsPath)) {
            Log::warning('FCM: Service account file not found at ' . $credentialsPath);
            return null;
        }

        try {
            $credentials = json_decode(file_get_contents($credentialsPath), true);

            $now = time();
            $header = base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $claim = base64_encode(json_encode([
                'iss'   => $credentials['client_email'],
                'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
                'aud'   => 'https://oauth2.googleapis.com/token',
                'iat'   => $now,
                'exp'   => $now + 3600,
            ]));

            $unsignedJwt = $header . '.' . $claim;

            openssl_sign($unsignedJwt, $signature, $credentials['private_key'], 'SHA256');
            $jwt = $unsignedJwt . '.' . base64_encode($signature);

            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]);

            return $response->json('access_token');
        } catch (\Exception $e) {
            Log::error('FCM: Failed to get access token: ' . $e->getMessage());
            return null;
        }
    }
}
