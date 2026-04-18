@extends('admin.layout')
@section('title', 'Account Deletion Requests')
@section('page-title', 'Account Deletion Requests')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Account Deletions</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500">Account Deletion Requests</h6>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
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
                                <th><span class="userDatatable-title">Reason</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title">Requested</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        @include('admin.account-deletions.partials.table')
                    </table>
                </div>

                <div id="pagination-wrapper">
                    @include('admin.partials.pagination', ['data' => $requests])
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
