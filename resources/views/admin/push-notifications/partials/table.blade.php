<tbody id="table-body">
    @forelse($notifications as $i => $notification)
    <tr>
        <td><div class="userDatatable-content">{{ $notifications->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $notification->title }}</span>
                <small class="color-light">{{ Str::limit($notification->body, 50) }}</small>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge badge-round badge-primary">{{ ucfirst($notification->target) }}</span>
            </div>
        </td>
        <td><div class="userDatatable-content fw-500">{{ number_format($notification->sent_count ?? 0) }}</div></td>
        <td>
            <div class="userDatatable-content">
                @if($notification->status === 'sent')
                    <span class="badge badge-round badge-success">Sent</span>
                @elseif($notification->status === 'scheduled')
                    <span class="badge badge-round badge-warning">Scheduled</span>
                @else
                    <span class="badge badge-round badge-danger">Failed</span>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($notification->sent_at)
                    {{ $notification->sent_at->format('d M Y') }}<br>
                    <small class="color-light">{{ $notification->sent_at->format('H:i') }}</small>
                @elseif($notification->scheduled_at)
                    {{ $notification->scheduled_at->format('d M Y') }}<br>
                    <small class="color-light">{{ $notification->scheduled_at->format('H:i') }}</small>
                @else
                    <span class="color-light">-</span>
                @endif
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.push-notifications.show', $notification) }}" class="view" title="View">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.push-notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="remove" title="Delete"><i class="uil uil-trash-alt"></i></button>
                    </form>
                </li>
            </ul>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center py-30">
            <i class="uil uil-bell fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No notifications found</p>
        </td>
    </tr>
    @endforelse
</tbody>
