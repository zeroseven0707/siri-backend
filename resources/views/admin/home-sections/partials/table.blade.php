<tbody id="table-body">
    @forelse($sections as $i => $section)
    <tr>
        <td><div class="userDatatable-content">{{ $sections->firstItem() + $i }}</div></td>
        <td><div class="userDatatable-content fw-500">{{ $section->order }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $section->title }}</span>
                @if($section->subtitle)
                    <small class="color-light">{{ $section->subtitle }}</small>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="badge badge-round badge-primary">{{ ucfirst($section->type) }}</span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($section->is_active)
                    <span class="badge badge-round badge-success">Active</span>
                @else
                    <span class="badge badge-round badge-danger">Inactive</span>
                @endif
            </div>
        </td>
        <td><div class="userDatatable-content">{{ $section->created_at->format('d M Y') }}</div></td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.home-sections.edit', $section) }}" class="edit" title="Edit">
                        <i class="uil uil-edit"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.home-sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
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
            <i class="uil uil-apps fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No home sections found</p>
        </td>
    </tr>
    @endforelse
</tbody>
