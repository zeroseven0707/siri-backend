@extends('admin.layout')
@section('title', 'Detail Driver - ' . $driver->name)
@section('page-title', 'Detail Driver')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">Drivers</a></li>
        <li class="breadcrumb-item active">{{ $driver->name }}</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    {{-- Left: Profile Card --}}
    <div class="col-lg-4 mb-25">
        <div class="card border-0">
            <div class="card-body p-30 text-center">
                <div class="account-profile">
                    <div class="ap-img mb-20 justify-content-center">
                        @if($driver->profile_picture)
                            <img src="{{ asset('storage/'.$driver->profile_picture) }}" class="rounded-circle border-white" width="120" height="120" style="object-fit:cover; border: 4px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.08)">
                        @else
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold mx-auto shadow-sm" style="width:120px;height:120px;font-size:42px">
                                {{ strtoupper(substr($driver->name,0,1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="ap-nameAddress">
                        <h5 class="fw-700 text-dark mb-5">{{ $driver->name }}</h5>
                        <p class="fs-13 color-light mb-15">{{ $driver->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-10 mb-20">
                            @if($driver->is_active)
                                <span class="badge badge-round badge-success px-15">Active Driver</span>
                            @else
                                <span class="badge badge-round badge-danger px-15">Inactive</span>
                            @endif
                            <span class="badge badge-round badge-secondary px-15">{{ ucfirst($driver->driverProfile?->vehicle_type ?? 'N/A') }}</span>
                        </div>
                    </div>

                    <div class="ap-info-details border-top pt-25 text-start">
                        <div class="d-flex align-items-center mb-15">
                            <div class="svg-icon order-bg-opacity-primary color-primary me-15" style="width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center">
                                <i class="uil uil-phone"></i>
                            </div>
                            <div>
                                <p class="fs-12 color-light mb-0">Phone Number</p>
                                <h6 class="fw-600 fs-14 mb-0">{{ $driver->phone ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-15">
                            <div class="svg-icon order-bg-opacity-info color-info me-15" style="width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center">
                                <i class="uil uil-postcard"></i>
                            </div>
                            <div>
                                <p class="fs-12 color-light mb-0">License Plate</p>
                                <h6 class="fw-600 fs-14 mb-0">{{ $driver->driverProfile?->license_plate ?? '-' }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-15">
                            <div class="svg-icon order-bg-opacity-warning color-warning me-15" style="width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div>
                                <p class="fs-12 color-light mb-0">Join Date</p>
                                <h6 class="fw-600 fs-14 mb-0">{{ $driver->created_at->format('d F Y') }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="pt-20">
                        <form method="POST" action="{{ route('admin.drivers.toggle-active', $driver) }}">
                            @csrf
                            <button type="submit" class="btn btn-{{ $driver->is_active ? 'warning' : 'success' }} btn-default btn-squared w-100">
                                <i class="uil uil-power me-5"></i>
                                {{ $driver->is_active ? 'Deactivate Driver' : 'Activate Driver' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Stats & Orders --}}
    <div class="col-lg-8">
        {{-- Stat Cards --}}
        <div class="row">
            <div class="col-sm-6 mb-25">
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>{{ number_format($completedCount) }}</h1>
                                <p>Orders Completed</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-success color-success">
                                    <i class="uil uil-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-25">
                <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
                    <div class="overview-content w-100">
                        <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                            <div class="ap-po-details__titlebar">
                                <h1>Rp {{ number_format($earnings, 0, ',', '.') }}</h1>
                                <p>Total Earnings</p>
                            </div>
                            <div class="ap-po-details__icon-area">
                                <div class="svg-icon order-bg-opacity-primary color-primary">
                                    <i class="uil uil-usd-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order History Table --}}
        <div class="card border-0">
            <div class="card-header border-bottom py-20 px-30">
                <h6 class="fw-500">Order History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">Order Info</span></th>
                                <th><span class="userDatatable-title">Service</span></th>
                                <th><span class="userDatatable-title">Delivery Fee</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <div class="userDatatable-content">
                                            <strong>#{{ $order->id }}</strong>
                                            <p class="mb-0 fs-12 text-muted">{{ $order->user?->name ?? 'Unknown Customer' }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="userDatatable-content">
                                            <span class="color-dark">{{ $order->service?->name ?? 'N/A' }}</span>
                                            <p class="mb-0 fs-11 text-muted">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="userDatatable-content">
                                            <span class="fw-600 color-success">Rp {{ number_format($order->delivery_fee ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="userDatatable-content">
                                            @php 
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'accepted' => 'info',
                                                    'on_progress' => 'primary',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ][$order->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-round badge-{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="userDatatable-content text-end ps-0">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary btn-rounded">
                                                <i class="uil uil-eye"></i> View
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center py-50">
                                            <img src="{{ asset('admin-assets/img/svg/empty-state.svg') }}" alt="Empty" style="max-width: 150px;" class="mb-15">
                                            <p class="text-muted">No orders recorded for this driver yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders->hasPages())
                    <div class="d-flex justify-content-end p-20 border-top">
                        {{ $orders->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
