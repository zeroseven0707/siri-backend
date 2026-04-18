<tbody id="table-body">
    @forelse($users as $i => $user)
    <tr>
        <td><div class="userDatatable-content">{{ $users->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content d-flex align-items-center">
                <div class="rounded-circle me-2 d-flex align-items-center justify-content-center fw-500"
                    style="width:34px;height:34px;background:linear-gradient(135deg,#EC4899,#A855F7);color:#fff;font-size:14px;flex-shrink:0;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <span class="fw-500 d-block">{{ $user->name }}</span>
                    <small class="color-light">{{ $user->email }}</small>
                </div>
            </div>
        </td>
        <td><div class="userDatatable-content">{{ $user->phone ?? '-' }}</div></td>
        <td>
            <div class="userDatatable-content">
                @if($user->role === 'admin')
                    <span class="badge badge-round badge-danger"><i class="uil uil-shield-check me-1"></i>Admin</span>
                @elseif($user->role === 'driver')
                    <span class="badge badge-round badge-primary"><i class="uil uil-car me-1"></i>Driver</span>
                @else
                    <span class="badge badge-round badge-success"><i class="uil uil-user me-1"></i>User</span>
                @endif
            </div>
        </td>
        <td><div class="userDatatable-content">{{ $user->created_at->format('d M Y') }}</div></td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.users.edit', $user) }}" class="edit" title="Edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="remove" title="Delete"><i class="uil uil-trash-alt"></i></button>
                    </form>
                </li>
            </ul>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-30">
            <i class="uil uil-users-alt fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No users found</p>
        </td>
    </tr>
    @endforelse
</tbody>
