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

        $readIds = $user->readNotifications()->pluck('push_notification_id')->toArray();

        $notifications = PushNotification::whereIn('target', ['all', $user->role])
            ->whereNotNull('sent_at')
            ->latest('sent_at')
            ->paginate(20);

        $data = $notifications->getCollection()->map(function ($notif) use ($readIds) {
            $notif->is_read = in_array($notif->id, $readIds);
            return $notif;
        });

        // Hitung unread dari total, bukan hanya halaman ini
        $unreadCount = PushNotification::whereIn('target', ['all', $user->role])
            ->whereNotNull('sent_at')
            ->whereNotIn('id', $readIds)
            ->count();

        return $this->success([
            'notifications' => PushNotificationResource::collection($data),
            'unread_count'  => $unreadCount,
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
