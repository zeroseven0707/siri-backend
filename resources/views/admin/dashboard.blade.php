@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Overview</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <!-- Stats Cards -->
        <div class="col-xxl-3 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ number_format($stats['total_users']) }}</h1>
                            <p>Total Users</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-primary color-primary">
                                <i class="uil uil-users-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i></span>
                        <small>Registered users</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ number_format($stats['total_orders']) }}</h1>
                            <p>Total Orders</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-info color-info">
                                <i class="uil uil-shopping-cart-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i></span>
                        <small>All time orders</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ number_format($stats['total_stores']) }}</h1>
                            <p>Total Stores</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-secondary color-secondary">
                                <i class="uil uil-store"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i></span>
                        <small>Active stores</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>Rp {{ number_format($stats['total_revenue']) }}</h1>
                            <p>Total Revenue</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-success color-success">
                                <i class="uil uil-usd-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-arrow-up"></i></span>
                        <small>Total earnings</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Stats -->
    <div class="row">
        <div class="col-xxl-6 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ number_format($stats['pending_orders']) }}</h1>
                            <p>Pending Orders</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-warning color-warning">
                                <i class="uil uil-clock"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-warning"><i class="las la-clock"></i></span>
                        <small>Awaiting processing</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 col-sm-6 mb-25">
            <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                <div class="overview-content w-100">
                    <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                        <div class="ap-po-details__titlebar">
                            <h1>{{ number_format($stats['completed_orders']) }}</h1>
                            <p>Completed Orders</p>
                        </div>
                        <div class="ap-po-details__icon-area">
                            <div class="svg-icon order-bg-opacity-success color-success">
                                <i class="uil uil-check-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ap-po-details-time">
                        <span class="color-success"><i class="las la-check-circle"></i></span>
                        <small>Successfully delivered</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-lg-12 mb-25">
            <div class="card border-0">
                <div class="card-header">
                    <h6 class="fw-500">Recent Orders</h6>
                    <div class="card-extra">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                            <i class="uil uil-eye"></i> View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th><span class="userDatatable-title">No.</span></th>
                                    <th><span class="userDatatable-title">Order ID</span></th>
                                    <th><span class="userDatatable-title">Customer</span></th>
                                    <th><span class="userDatatable-title">Store/Service</span></th>
                                    <th><span class="userDatatable-title">Total</span></th>
                                    <th><span class="userDatatable-title">Status</span></th>
                                    <th><span class="userDatatable-title text-end">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                    <tr>
                                        <td class="ps-20">{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <strong>#{{ $order->order_number ?? $order->id }}</strong>
                                                <p>{{ $order->created_at->format('d M Y, H:i A') }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                {{ $order->user->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($order->foodItems->isNotEmpty())
                                                    {{ $order->foodItems->first()->foodItem->store->name ?? 'N/A' }}
                                                @else
                                                    {{ $order->service->name ?? 'Service Order' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                <strong>Rp {{ number_format($order->total_price ?? $order->price) }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content">
                                                @if($order->status === 'pending')
                                                    <span class="badge badge-round badge-warning">Pending</span>
                                                @elseif($order->status === 'completed')
                                                    <span class="badge badge-round badge-success">Completed</span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="badge badge-round badge-danger">Cancelled</span>
                                                @else
                                                    <span class="badge badge-round badge-primary">{{ ucfirst($order->status) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="userDatatable-content text-end">
                                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="uil uil-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="dm-empty text-center">
                                                <div class="dm-empty__image">
                                                    <img src="{{ asset('admin-assets/img/svg/empty-state.svg') }}" alt="Empty" style="max-width: 200px;">
                                                </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
