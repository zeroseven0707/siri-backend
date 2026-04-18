<div wire:poll.10s>
    {{-- Search --}}
    <div class="mb-20">
        <div class="row g-2">
            <div class="col-md-5">
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    class="form-control"
                    placeholder="Search order number or customer..."
                >
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="order-tabs mb-20">
        @php
            $tabs = [
                'accepted'    => ['label' => 'Accepted',    'color' => 'info',      'badge' => true],
                'pending'     => ['label' => 'Pending',     'color' => 'warning',   'badge' => true],
                'on_progress' => ['label' => 'On Progress', 'color' => 'primary',   'badge' => true],
                'completed'   => ['label' => 'Completed',   'color' => 'success',   'badge' => false],
                'cancelled'   => ['label' => 'Cancelled',   'color' => 'danger',    'badge' => false],
            ];
        @endphp

        <ul class="nav order-status-tabs" role="tablist">
            @foreach($tabs as $key => $tab)
            <li class="nav-item">
                <button
                    wire:click="setTab('{{ $key }}')"
                    class="nav-link order-tab-btn {{ $activeTab === $key ? 'active' : '' }}"
                    type="button"
                >
                    {{ $tab['label'] }}
                    @if($tab['badge'])
                        <span class="tab-count tab-count--{{ $tab['color'] }}">
                            {{ $counts[$key] }}
                        </span>
                    @endif
                </button>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr class="userDatatable-header">
                    <th><span class="userDatatable-title">#</span></th>
                    <th><span class="userDatatable-title">Order No</span></th>
                    <th><span class="userDatatable-title">Customer</span></th>
                    <th><span class="userDatatable-title">Store/Service</span></th>
                    <th><span class="userDatatable-title">Driver</span></th>
                    <th><span class="userDatatable-title">Total</span></th>
                    <th><span class="userDatatable-title">Status</span></th>
                    <th><span class="userDatatable-title">Date</span></th>
                    <th><span class="userDatatable-title text-end">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $i => $order)
                <tr>
                    <td><div class="userDatatable-content">{{ $orders->firstItem() + $i }}</div></td>
                    <td>
                        <div class="userDatatable-content fw-500">
                            #{{ $order->order_number ?? $order->id }}
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
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?')" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="remove" title="Delete">
                                        <i class="uil uil-trash-alt"></i>
                                    </button>
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
        </table>
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
    <div class="d-flex justify-content-between align-items-center pt-20 flex-wrap gap-2">
        <div class="color-light fs-13">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
        </div>
        <ul class="dm-pagination d-flex mb-0">
            <li class="dm-pagination__item {{ $orders->onFirstPage() ? 'disabled' : '' }}">
                <button wire:click="previousPage" class="dm-pagination__link" {{ $orders->onFirstPage() ? 'disabled' : '' }}>
                    <span class="la la-angle-left"></span>
                </button>
            </li>
            @foreach($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
            <li class="dm-pagination__item {{ $page == $orders->currentPage() ? 'active' : '' }}">
                <button wire:click="gotoPage({{ $page }})" class="dm-pagination__link">{{ $page }}</button>
            </li>
            @endforeach
            <li class="dm-pagination__item {{ !$orders->hasMorePages() ? 'disabled' : '' }}">
                <button wire:click="nextPage" class="dm-pagination__link" {{ !$orders->hasMorePages() ? 'disabled' : '' }}>
                    <span class="la la-angle-right"></span>
                </button>
            </li>
        </ul>
    </div>
    @endif
</div>
