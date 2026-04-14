@extends('admin.layout')

@section('title', 'Orders')
@section('page-title', 'Orders Management')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0">
                <div class="card-header">
                    <h6 class="fw-500">All Orders</h6>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-25">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search by order number..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <div class="col-md-3 mb-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="on_progress" {{ request('status') === 'on_progress' ? 'selected' : '' }}>On Progress</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="uil uil-filter"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-light w-100">
                                    <i class="uil uil-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th><span class="userDatatable-title">Order ID</span></th>
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
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="userDatatable-content">
                                                <strong>#{{ $order->order_number ?? $order->id }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <h6 class="mb-0">{{ $order->user->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($order->foodItems->isNotEmpty())
                                                    <i class="uil uil-store text-primary"></i>
                                                    {{ $order->foodItems->first()->foodItem->store->name ?? 'N/A' }}
                                                @else
                                                    <i class="uil uil-car text-info"></i>
                                                    {{ $order->service->name ?? 'Service Order' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($order->driver)
                                                    <i class="uil uil-user-circle"></i> {{ $order->driver->name }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <strong class="text-success">Rp {{ number_format($order->total_price ?? $order->price) }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($order->status === 'pending')
                                                    <span class="badge badge-round badge-warning">
                                                        <i class="uil uil-clock"></i> Pending
                                                    </span>
                                                @elseif($order->status === 'accepted')
                                                    <span class="badge badge-round badge-info">
                                                        <i class="uil uil-check"></i> Accepted
                                                    </span>
                                                @elseif($order->status === 'on_progress')
                                                    <span class="badge badge-round badge-primary">
                                                        <i class="uil uil-truck"></i> On Progress
                                                    </span>
                                                @elseif($order->status === 'completed')
                                                    <span class="badge badge-round badge-success">
                                                        <i class="uil uil-check-circle"></i> Completed
                                                    </span>
                                                @else
                                                    <span class="badge badge-round badge-danger">
                                                        <i class="uil uil-times-circle"></i> Cancelled
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $order->created_at->format('d M Y') }}<br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                                                <li>
                                                    <a href="{{ route('admin.orders.show', $order) }}" class="view">
                                                        <i class="uil uil-eye"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="remove" style="background: none; border: none; cursor: pointer; color: #e85347;">
                                                            <i class="uil uil-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="dm-empty text-center">
                                                <div class="dm-empty__text">
                                                    <p class="mb-0">No orders found</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-end pt-30">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .orderDatatable_actions {
        display: flex;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .orderDatatable_actions .view,
    .orderDatatable_actions .remove {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .orderDatatable_actions .view {
        background: rgba(1, 104, 250, 0.1);
        color: #0168fa;
    }
    .orderDatatable_actions .view:hover {
        background: #0168fa;
        color: #fff;
    }
    .orderDatatable_actions .remove {
        background: rgba(232, 83, 71, 0.1);
        color: #e85347;
    }
    .orderDatatable_actions .remove:hover {
        background: #e85347;
        color: #fff;
    }
</style>
@endpush
