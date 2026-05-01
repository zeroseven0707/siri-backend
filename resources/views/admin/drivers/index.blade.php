@extends('admin.layout')
@section('title', 'Driver Management')
@section('page-title', 'Driver Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Drivers</li>
    </ol>
</nav>
@endsection

@section('content')

{{-- Stats --}}
<div class="row mb-25">
    <div class="col-md-4 mb-15">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1>{{ $stats['total'] }}</h1>
                        <p>Total Drivers</p>
                    </div>
                    <div class="ap-po-details__icon-area">
                        <div class="svg-icon order-bg-opacity-primary color-primary">
                            <i class="uil uil-users-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-15">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1 class="color-success">{{ $stats['active'] }}</h1>
                        <p>Active Drivers</p>
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
    <div class="col-md-4 mb-15">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1 class="color-danger">{{ $stats['inactive'] }}</h1>
                        <p>Inactive Drivers</p>
                    </div>
                    <div class="ap-po-details__icon-area">
                        <div class="svg-icon order-bg-opacity-danger color-danger">
                            <i class="uil uil-user-times"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card border-0">
            <div class="card-header d-flex justify-content-between align-items-center border-bottom py-20 px-30">
                <h6 class="fw-500">All Drivers</h6>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20 px-15">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search name, email or phone..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="active" @selected(request('status') === 'active')>Active Only</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive Only</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-default btn-squared w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <div id="table-wrapper" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">#</span></th>
                                <th><span class="userDatatable-title">Driver Information</span></th>
                                <th><span class="userDatatable-title">Vehicle Info</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title">Completed Orders</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                @forelse($drivers as $i => $driver)
                <tr>
                    <td>
                        <div class="userDatatable-content">{{ $drivers->firstItem() + $i }}</div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-12">
                            <div class="userDatatable-inline-title">
                                @if($driver->profile_picture)
                                    <img src="{{ asset('storage/'.$driver->profile_picture) }}" class="rounded-circle" width="40" height="40" style="object-fit:cover">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width:40px;height:40px;font-size:16px">
                                        {{ strtoupper(substr($driver->name,0,1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="userDatatable-content">
                                <h6 class="fw-600 mb-0">{{ $driver->name }}</h6>
                                <p class="mb-0 fs-12 text-muted">{{ $driver->email }} · {{ $driver->phone ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <span class="fw-500 color-dark text-capitalize">{{ $driver->driverProfile?->vehicle_type ?? 'N/A' }}</span>
                            <p class="mb-0 fs-12 text-muted">{{ $driver->driverProfile?->license_plate ?? 'No Plate' }}</p>
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            @if($driver->is_active)
                                <span class="badge badge-round badge-success">Active</span>
                            @else
                                <span class="badge badge-round badge-danger">Inactive</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="userDatatable-content">
                            <span class="fw-600 color-primary">{{ \App\Models\Order::where('driver_id',$driver->id)->where('status','completed')->count() }}</span>
                        </div>
                    </td>
                    <td>
                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap justify-content-end">
                            <li>
                                <a href="{{ route('admin.drivers.show', $driver) }}" class="view" title="View Detail">
                                    <i class="uil uil-eye"></i>
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.drivers.toggle-active', $driver) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="edit" title="{{ $driver->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="uil uil-power"></i>
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.drivers.destroy', $driver) }}" onsubmit="return confirm('Hapus driver ini?')" style="display:inline">
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
                        <i class="uil uil-users-alt fs-30 color-light d-block mb-10"></i>
                        <p class="mb-0 color-light">No drivers found</p>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
                <div id="pagination-wrapper" class="pt-25">
                    @include('admin.partials.pagination', ['data' => $drivers])
                </div>
    </div>
</div>
@endsection

@push('styles')
@include('admin.partials.table-styles')
@endpush

@push('scripts')
@include('admin.partials.ajax-table-script')
@endpush
