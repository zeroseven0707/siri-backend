<tbody id="table-body">
    @forelse($services as $i => $service)
    <tr>
        <td><div class="userDatatable-content">{{ $services->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $service->name }}</span>
                @if($service->description)
                    <small class="color-light">{{ Str::limit($service->description, 50) }}</small>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content fw-500 color-success">
                Rp {{ number_format($service->base_price) }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($service->is_active)
                    <span class="badge badge-round badge-success">Active</span>
                @else
                    <span class="badge badge-round badge-danger">Inactive</span>
                @endif
            </div>
        </td>
        <td><div class="userDatatable-content">{{ $service->created_at->format('d M Y') }}</div></td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.services.edit', $service) }}" class="edit" title="Edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
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
            <i class="uil uil-car fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No services found</p>
        </td>
    </tr>
    @endforelse
</tbody>
