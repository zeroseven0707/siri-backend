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
        private \App\Services\FcmService $fcmService
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

        $validated['status']  = $request->filled('scheduled_at') ? 'scheduled' : 'sent';
        $validated['sent_at'] = $request->filled('scheduled_at') ? null : now();
        $validated['sent_by'] = auth()->id();
        $validated['type']    = 'system';

        // Map UI targets (plural) to DB targets (singular)
        if ($validated['target'] === 'users') $validated['target'] = 'user';
        if ($validated['target'] === 'drivers') $validated['target'] = 'driver';

        $notification = PushNotification::create($validated);

        // Send notification immediately if not scheduled
        if (!$request->filled('scheduled_at')) {
            $this->fcmService->broadcast($notification);
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
}
