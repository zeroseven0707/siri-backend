@extends('admin.layout')
@section('title', 'Transactions')
@section('page-title', 'Transactions')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Transactions</li>
    </ol>
</nav>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="row">
    <div class="col-xxl-3 col-sm-6 mb-25">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1>Rp {{ number_format($stats['total_amount']) }}</h1>
                        <p>Total Amount</p>
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
    <div class="col-xxl-3 col-sm-6 mb-25">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1>{{ number_format($stats['pending_count']) }}</h1>
                        <p>Pending</p>
                    </div>
                    <div class="ap-po-details__icon-area">
                        <div class="svg-icon order-bg-opacity-warning color-warning">
                            <i class="uil uil-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-3 col-sm-6 mb-25">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1>{{ number_format($stats['completed_count']) }}</h1>
                        <p>Completed</p>
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
    <div class="col-xxl-3 col-sm-6 mb-25">
        <div class="ap-po-details ap-po-details--2 p-25 radius-xl d-flex justify-content-between">
            <div class="overview-content w-100">
                <div class="ap-po-details-content d-flex flex-wrap justify-content-between">
                    <div class="ap-po-details__titlebar">
                        <h1>{{ number_format($stats['failed_count']) }}</h1>
                        <p>Failed</p>
                    </div>
                    <div class="ap-po-details__icon-area">
                        <div class="svg-icon order-bg-opacity-danger color-danger">
                            <i class="uil uil-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500">All Transactions</h6>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by user..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-control">
                                <option value="">All Types</option>
                                <option value="top_up" {{ request('type') === 'top_up' ? 'selected' : '' }}>Top Up</option>
                                <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payment</option>
                                <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>Refund</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div id="table-wrapper" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">#</span></th>
                                <th><span class="userDatatable-title">User</span></th>
                                <th><span class="userDatatable-title">Type</span></th>
                                <th><span class="userDatatable-title">Amount</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title">Date</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        @include('admin.transactions.partials.table')
                    </table>
                </div>

                <div id="pagination-wrapper">
                    @include('admin.partials.pagination', ['data' => $transactions])
                </div>
            </div>
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
