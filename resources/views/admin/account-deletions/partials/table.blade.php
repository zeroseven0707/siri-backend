<tbody id="table-body">
    @forelse($requests as $i => $request)
    <tr>
        <td><div class="userDatatable-content">{{ $requests->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $request->user->name ?? 'Deleted User' }}</span>
                <small class="color-light">{{ $request->user->email ?? '-' }}</small>
            </div>
        </td>
        <td><div class="userDatatable-content">{{ Str::limit($request->reason, 50) }}</div></td>
        <td>
            <div class="userDatatable-content">
                {{ $request->created_at->format('d M Y') }}<br>
                <small class="color-light">{{ $request->created_at->format('H:i') }}</small>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @php
                    $deleteAt = $request->created_at->addDays(3);
                    $now = now();
                    $diff = $deleteAt->diff($now);
                @endphp
                @if($now->lt($deleteAt))
                    <span class="badge badge-round badge-warning">
                        {{ $diff->days }}d {{ $diff->h }}h {{ $diff->i }}m
                    </span>
                @else
                    <span class="badge badge-round badge-danger">Overdue</span>
                @endif
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.account-deletions.show', $request) }}" class="view" title="View">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-30">
            <i class="uil uil-trash-alt fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No deletion requests found</p>
        </td>
    </tr>
    @endforelse
</tbody>
