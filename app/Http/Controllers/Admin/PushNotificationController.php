<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
    public function __construct(
        private FirebaseService $firebaseService
    ) {}

    public function index(Request $request)
    {
        $query = PushNotification::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $notifications = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.push-notifications.partials.table', compact('notifications'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $notifications])->render(),
            ]);
        }

        return view('admin.push-notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.push-notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'target' => 'required|in:all,users,drivers',
            'scheduled_at' => 'nullable|date',
        ]);

        $validated['status'] = $request->filled('scheduled_at') ? 'scheduled' : 'sent';
        $validated['sent_at'] = $request->filled('scheduled_at') ? null : now();

        $notification = PushNotification::create($validated);

        // Send notification immediately if not scheduled
        if (!$request->filled('scheduled_at')) {
            $this->sendNotification($notification);
        }

        return redirect()->route('admin.push-notifications.index')
            ->with('success', 'Push notification created successfully');
    }

    public function show(PushNotification $pushNotification)
    {
        return view('admin.push-notifications.show', compact('pushNotification'));
    }

    public function destroy(PushNotification $pushNotification)
    {
        $pushNotification->delete();

        return redirect()->route('admin.push-notifications.index')
            ->with('success', 'Push notification deleted successfully');
    }

    private function sendNotification(PushNotification $notification)
    {
        // Get target users based on notification target
        $users = match($notification->target) {
            'all' => User::whereNotNull('fcm_token')->get(),
            'users' => User::where('role', 'user')->whereNotNull('fcm_token')->get(),
            'drivers' => User::where('role', 'driver')->whereNotNull('fcm_token')->get(),
            default => collect([]),
        };

        if ($users->isEmpty()) {
            $notification->update([
                'sent_count' => 0,
                'sent_at' => now(),
                'status' => 'sent'
            ]);
            return;
        }

        // Get FCM tokens
        $fcmTokens = $users->pluck('fcm_token')->filter()->toArray();

        // Send via Firebase
        $results = $this->firebaseService->sendToMultipleDevices(
            $fcmTokens,
            $notification->title,
            $notification->body,
            [
                'notification_id' => $notification->id,
                'type' => 'general',
            ]
        );

        // Update notification with results
        $notification->update([
            'sent_count' => $results['success'],
            'sent_at' => now(),
            'status' => 'sent'
        ]);
    }
}
