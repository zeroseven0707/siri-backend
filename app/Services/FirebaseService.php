<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    private string $serverKey;
    private string $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    public function __construct()
    {
        $this->serverKey = config('services.firebase.server_key');
    }

    /**
     * Send notification to single device
     */
    public function sendToDevice(string $fcmToken, string $title, string $body, array $data = []): bool
    {
        return $this->send([
            'to' => $fcmToken,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'badge' => '1',
            ],
            'data' => $data,
            'priority' => 'high',
        ]);
    }

    /**
     * Send notification to multiple devices
     */
    public function sendToMultipleDevices(array $fcmTokens, string $title, string $body, array $data = []): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        // FCM allows max 1000 tokens per request, so we chunk them
        $chunks = array_chunk($fcmTokens, 1000);

        foreach ($chunks as $chunk) {
            $response = $this->send([
                'registration_ids' => $chunk,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'sound' => 'default',
                    'badge' => '1',
                ],
                'data' => $data,
                'priority' => 'high',
            ]);

            if ($response) {
                $results['success'] += count($chunk);
            } else {
                $results['failed'] += count($chunk);
            }
        }

        return $results;
    }

    /**
     * Send notification to topic
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        return $this->send([
            'to' => '/topics/' . $topic,
            'notification' => [
                'title' => $title,
                'body' => $body,
                'sound' => 'default',
                'badge' => '1',
            ],
            'data' => $data,
            'priority' => 'high',
        ]);
    }

    /**
     * Send raw FCM request
     */
    private function send(array $payload): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->post($this->fcmUrl, $payload);

            if ($response->successful()) {
                Log::info('FCM notification sent successfully', [
                    'response' => $response->json(),
                ]);
                return true;
            }

            Log::error('FCM notification failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('FCM notification exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

    /**
     * Subscribe device to topic
     */
    public function subscribeToTopic(string $fcmToken, string $topic): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->post('https://iid.googleapis.com/iid/v1/' . $fcmToken . '/rel/topics/' . $topic);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('FCM topic subscription failed', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Unsubscribe device from topic
     */
    public function unsubscribeFromTopic(string $fcmToken, string $topic): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'key=' . $this->serverKey,
                'Content-Type' => 'application/json',
            ])->delete('https://iid.googleapis.com/iid/v1/' . $fcmToken . '/rel/topics/' . $topic);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('FCM topic unsubscription failed', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
