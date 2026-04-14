@extends('admin.layout')

@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Order Details -->
        <div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Order #{{ $order->order_number ?? $order->id }}</h2>
                    @if($order->status === 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($order->status === 'accepted')
                        <span class="badge badge-primary">Accepted</span>
                    @elseif($order->status === 'on_progress')
                        <span class="badge badge-primary">On Progress</span>
                    @elseif($order->status === 'completed')
                        <span class="badge badge-success">Completed</span>
                    @else
                        <span class="badge badge-danger">Cancelled</span>
                    @endif
                </div>

                <div style="padding: 0 1.5rem 1.5rem;">
                    <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Order Items</h3>
                    @if($order->items->isNotEmpty())
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->foodItem->name ?? 'N/A' }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>Rp {{ number_format($item->price) }}</td>
                                        <td><strong>Rp {{ number_format($item->price * $item->qty) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: 600;">Delivery Fee:</td>
                                    <td><strong>Rp {{ number_format($order->delivery_fee ?? 0) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: 700; font-size: 1.125rem;">Total:</td>
                                    <td style="font-weight: 700; font-size: 1.125rem; color: var(--primary);">
                                        Rp {{ number_format($order->total_price ?? $order->price) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <div style="padding: 2rem; text-align: center; background: var(--light); border-radius: 8px;">
                            <p style="color: var(--gray);">This is a service order</p>
                            <p style="font-size: 1.5rem; font-weight: 700; color: var(--primary); margin-top: 1rem;">
                                Rp {{ number_format($order->price) }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Delivery Address</h3>
                <p style="color: var(--gray); line-height: 1.6;">
                    {{ $order->delivery_address ?? 'No address provided' }}
                </p>
                @if($order->notes)
                    <div style="margin-top: 1rem; padding: 1rem; background: var(--light); border-radius: 8px;">
                        <strong>Notes:</strong><br>
                        {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Customer Info -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Customer</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray);">Name</div>
                        <div style="font-weight: 600;">{{ $order->user->name }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray);">Email</div>
                        <div>{{ $order->user->email }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray);">Phone</div>
                        <div>{{ $order->user->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Store Info -->
            @if($order->items->isNotEmpty() && $order->items->first()->foodItem->store)
                <div class="card">
                    <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Store</h3>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Name</div>
                            <div style="font-weight: 600;">{{ $order->items->first()->foodItem->store->name }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Address</div>
                            <div>{{ $order->items->first()->foodItem->store->address }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Phone</div>
                            <div>{{ $order->items->first()->foodItem->store->phone }}</div>
                        </div>
                    </div>
                </div>
            @elseif($order->service)
                <div class="card">
                    <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Service</h3>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Service Type</div>
                            <div style="font-weight: 600;">{{ $order->service->name }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Pickup Location</div>
                            <div>{{ $order->pickup_location }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Destination</div>
                            <div>{{ $order->destination_location }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Driver Info -->
            @if($order->driver)
                <div class="card">
                    <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Driver</h3>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Name</div>
                            <div style="font-weight: 600;">{{ $order->driver->name }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.875rem; color: var(--gray);">Phone</div>
                            <div>{{ $order->driver->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Update Status -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Update Status</h3>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="on_progress" {{ $order->status === 'on_progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Update Status</button>
                </form>
            </div>

            <!-- Order Info -->
            <div class="card">
                <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Order Info</h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.875rem;">
                    <div>
                        <div style="color: var(--gray);">Created</div>
                        <div>{{ $order->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div>
                        <div style="color: var(--gray);">Updated</div>
                        <div>{{ $order->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 1.5rem;">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Back to Orders</a>
    </div>
@endsection
