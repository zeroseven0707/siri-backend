<tbody id="table-body">
    @forelse($stores as $i => $store)
    <tr>
        <td><div class="userDatatable-content">{{ $stores->firstItem() + $i }}</div></td>
        <td><div class="userDatatable-content fw-500">{{ $store->name }}</div></td>
        <td><div class="userDatatable-content">{{ Str::limit($store->address, 40) }}</div></td>
        <td><div class="userDatatable-content">{{ $store->phone ?? '-' }}</div></td>
        <td>
            <div class="userDatatable-content">
                @if($store->is_open)
                    <span class="badge badge-round badge-success">Open</span>
                @else
                    <span class="badge badge-round badge-danger">Closed</span>
                @endif
            </div>
        </td>
        <td><div class="userDatatable-content">{{ $store->created_at->format('d M Y') }}</div></td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.stores.edit', $store) }}" class="edit" title="Edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
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
            <i class="uil uil-store fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No stores found</p>
        </td>
    </tr>
    @endforelse
</tbody>
