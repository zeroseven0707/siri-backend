<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PushNotificationResource;
use App\Models\PushNotification;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    // User: ambil notifikasi yang ditujukan ke dirinya
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $notifications = PushNotification::whereIn('target', ['all', $user->role])
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->paginate(20);

        // Tandai mana yang sudah dibaca oleh user ini
        $readIds = $user->load('readNotifications')
            ->readNotifications
            ->pluck('id')
            ->toArray();

        $data = $notifications->getCollection()->map(function ($notif) use ($readIds) {
            $notif->is_read = in_array($notif->id, $readIds);
            return $notif;
        });

        return $this->success([
            'notifications' => PushNotificationResource::collection($data),
            'unread_count'  => $notifications->getCollection()
                ->filter(fn ($n) => !$n->is_read)->count(),
            'pagination'    => [
                'current_page' => $notifications->currentPage(),
                'last_page'    => $notifications->lastPage(),
                'total'        => $notifications->total(),
            ],
        ]);
    }

    // User: tandai notifikasi sebagai sudah dibaca
    public function markRead(Request $request, string $id): JsonResponse
    {
        $notif = PushNotification::find($id);

        if (!$notif) {
            return $this->error('Notification not found', 404);
        }

        $request->user()->readNotifications()->syncWithoutDetaching([$id]);

        return $this->success(null, 'Marked as read');
    }

    // User: tandai semua sebagai sudah dibaca
    public function markAllRead(Request $request): JsonResponse
    {
        $user = $request->user();

        $ids = PushNotification::whereIn('target', ['all', $user->role])
            ->whereNotNull('sent_at')
            ->pluck('id')
            ->toArray();

        $user->readNotifications()->syncWithoutDetaching($ids);

        return $this->success(null, 'All marked as read');
    }
}
