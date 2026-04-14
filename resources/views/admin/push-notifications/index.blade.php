@extends('admin.layout')

@section('title', 'Push Notifications')
@section('page-title', 'Push Notifications')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">All Push Notifications</h2>
            <a href="{{ route('admin.push-notifications.create') }}" class="btn btn-primary">
                <span>➕</span> Send New Notification
            </a>
        </div>

        <!-- Search -->
        <form method="GET" style="padding: 0 1.5rem 1.5rem;">
            <div style="display: grid; grid-template-columns: 1fr 120px; gap: 1rem;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search notifications..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Target</th>
                        <th>Sent Count</th>
                        <th>Status</th>
                        <th>Sent At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notification)
                        <tr>
                            <td>
                                <strong>{{ $notification->title }}</strong>
                                <br><small style="color: var(--gray);">{{ Str::limit($notification->body, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ ucfirst($notification->target) }}</span>
                            </td>
                            <td>{{ number_format($notification->sent_count ?? 0) }}</td>
                            <td>
                                @if($notification->status === 'sent')
                                    <span class="badge badge-success">Sent</span>
                                @elseif($notification->status === 'scheduled')
                                    <span class="badge badge-warning">Scheduled</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>
                            <td>
                                @if($notification->sent_at)
                                    {{ $notification->sent_at->format('d M Y H:i') }}
                                @elseif($notification->scheduled_at)
                                    {{ $notification->scheduled_at->format('d M Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.push-notifications.show', $notification) }}" class="btn btn-secondary btn-sm">View</a>
                                    <form action="{{ route('admin.push-notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem; color: #9CA3AF;">
                                No notifications found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notifications->hasPages())
            <div style="padding: 1.5rem;">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
