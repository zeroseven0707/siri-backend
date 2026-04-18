@extends('admin.layout')
@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
        <li class="breadcrumb-item active">Details</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    {{-- Main Content --}}
    <div class="col-lg-8">
        {{-- Order Header --}}
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-shopping-cart-alt me-2"></i>Order #{{ $order->order_number ?? $order->id }}</h6>
                @if($order->status === 'pending')
                    <span class="badge badge-round badge-warning">Pending</span>
                @elseif($order->status === 'accepted')
                    <span class="badge badge-round badge-primary">Accepted</span>
                @elseif($order->status === 'on_progress')
                    <span class="badge badge-round badge-info">On Progress</span>
                @elseif($order->status === 'completed')
                    <span class="badge badge-round badge-success">Completed</span>
                @else
                    <span class="badge badge-round badge-danger">Cancelled</span>
                @endif
            </div>
            <div class="card-body">
                {{-- Order Items --}}
                @if($order->items->isNotEmpty())
                <h6 class="fw-500 mb-15">Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">Item</span></th>
                                <th><span class="userDatatable-title">Qty</span></th>
                                <th><span class="userDatatable-title">Price</span></th>
                                <th><span class="userDatatable-title">Subtotal</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td><div class="userDatatable-content">{{ $item->foodItem->name ?? 'N/A' }}</div></td>
                                <td><div class="userDatatable-content">{{ $item->qty }}</div></td>
                                <td><div class="userDatatable-content">Rp {{ number_format($item->price) }}</div></td>
                                <td><div class="userDatatable-content fw-500">Rp {{ number_format($item->price * $item->qty) }}</div></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-500">Delivery Fee:</td>
                                <td class="fw-500">Rp {{ number_format($order->delivery_fee ?? 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end fw-600 fs-15">Total:</td>
                                <td class="fw-600 fs-15 color-primary">Rp {{ number_format($order->total_price ?? $order->price) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-30">
                    <i class="uil uil-car fs-30 color-light mb-10 d-block"></i>
                    <p class="color-light mb-5">Service Order</p>
                    <p class="fw-600 fs-20 color-primary">Rp {{ number_format($order->price) }}</p>
                </div>
                @endif

                {{-- Delivery Address --}}
                <div class="mt-25 pt-20" style="border-top: 1px solid #f0f0f0;">
                    <h6 class="fw-500 mb-10"><i class="uil uil-map-marker me-2"></i>Delivery Address</h6>
                    <p class="color-light">{{ $order->delivery_address ?? 'No address provided' }}</p>
                    @if($order->notes)
                    <div class="p-15 mt-10" style="background:#f8f9fa; border-radius:8px;">
                        <span class="fw-500">Notes:</span> {{ $order->notes }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Service Info --}}
        @if($order->service)
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-car me-2"></i>Service Info</h6>
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Service Type</span>
                            <span class="summary-list__value">{{ $order->service->name }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Pickup Location</span>
                            <span class="summary-list__value">{{ $order->pickup_location }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Destination</span>
                            <span class="summary-list__value">{{ $order->destination_location }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Store Info --}}
        @if($order->items->isNotEmpty() && $order->items->first()->foodItem->store ?? null)
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-store me-2"></i>Store Info</h6>
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Store Name</span>
                            <span class="summary-list__value">{{ $order->items->first()->foodItem->store->name }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Address</span>
                            <span class="summary-list__value">{{ $order->items->first()->foodItem->store->address }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Phone</span>
                            <span class="summary-list__value">{{ $order->items->first()->foodItem->store->phone }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        {{-- Customer Info --}}
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-user me-2"></i>Customer</h6>
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Name</span>
                            <span class="summary-list__value fw-500">{{ $order->user->name }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Email</span>
                            <span class="summary-list__value">{{ $order->user->email }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Phone</span>
                            <span class="summary-list__value">{{ $order->user->phone ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Driver Info --}}
        @if($order->driver)
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-car me-2"></i>Driver</h6>
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Name</span>
                            <span class="summary-list__value fw-500">{{ $order->driver->name }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Phone</span>
                            <span class="summary-list__value">{{ $order->driver->phone ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Update Status --}}
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-refresh me-2"></i>Update Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Order Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="on_progress" {{ $order->status === 'on_progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize w-100">
                        <i class="uil uil-check me-1"></i> Update Status
                    </button>
                </form>
            </div>
        </div>

        {{-- Order Info --}}
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-info-circle me-2"></i>Order Info</h6>
            </div>
            <div class="card-body">
                <div class="invoice-summary-inner">
                    <ul class="summary-list">
                        <li>
                            <span class="summary-list__title">Created</span>
                            <span class="summary-list__value">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </li>
                        <li>
                            <span class="summary-list__title">Updated</span>
                            <span class="summary-list__value">{{ $order->updated_at->format('d M Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-15">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-light btn-default btn-squared text-capitalize w-100">
                        <i class="uil uil-arrow-left me-1"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
