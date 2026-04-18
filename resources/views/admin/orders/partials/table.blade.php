<tbody id="table-body">
    @forelse($orders as $i => $order)
    <tr>
        <td><div class="userDatatable-content">{{ $orders->firstItem() + $i }}</div></td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500">#{{ $order->order_number ?? $order->id }}</span>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                <span class="fw-500 d-block">{{ $order->user->name ?? 'N/A' }}</span>
                <small class="color-light">{{ $order->user->email ?? '' }}</small>
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($order->foodItems->isNotEmpty())
                    <i class="uil uil-store color-primary me-1"></i>
                    {{ $order->foodItems->first()->foodItem->store->name ?? 'N/A' }}
                @else
                    <i class="uil uil-car color-info me-1"></i>
                    {{ $order->service->name ?? 'Service Order' }}
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($order->driver)
                    <i class="uil uil-user-circle me-1"></i>{{ $order->driver->name }}
                @else
                    <span class="color-light">-</span>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content fw-500 color-success">
                Rp {{ number_format($order->total_price ?? $order->price) }}
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                @if($order->status === 'pending')
                    <span class="badge badge-round badge-warning">Pending</span>
                @elseif($order->status === 'accepted')
                    <span class="badge badge-round badge-info">Accepted</span>
                @elseif($order->status === 'on_progress')
                    <span class="badge badge-round badge-primary">On Progress</span>
                @elseif($order->status === 'completed')
                    <span class="badge badge-round badge-success">Completed</span>
                @else
                    <span class="badge badge-round badge-danger">Cancelled</span>
                @endif
            </div>
        </td>
        <td>
            <div class="userDatatable-content">
                {{ $order->created_at->format('d M Y') }}<br>
                <small class="color-light">{{ $order->created_at->format('H:i') }}</small>
            </div>
        </td>
        <td>
            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                <li>
                    <a href="{{ route('admin.orders.show', $order) }}" class="view" title="View">
                        <i class="uil uil-eye"></i>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="remove" title="Delete"><i class="uil uil-trash-alt"></i></button>
                    </form>
                </li>
            </ul>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center py-30">
            <i class="uil uil-shopping-cart-alt fs-30 color-light d-block mb-10"></i>
            <p class="mb-0 color-light">No orders found</p>
        </td>
    </tr>
    @endforelse
</tbody>
