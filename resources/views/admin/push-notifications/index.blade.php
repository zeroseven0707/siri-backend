@extends('admin.layout')
@section('title', 'Push Notifications')
@section('page-title', 'Push Notifications')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Push Notifications</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-500">All Push Notifications</h6>
                <a href="{{ route('admin.push-notifications.create') }}" class="btn btn-sm btn-primary">
                    <i class="uil uil-bell me-1"></i> Send Notification
                </a>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search notifications..." value="{{ request('search') }}">
                        </div>
                    </div>
                </form>

                <div id="table-wrapper" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">#</span></th>
                                <th><span class="userDatatable-title">Title</span></th>
                                <th><span class="userDatatable-title">Target</span></th>
                                <th><span class="userDatatable-title">Sent Count</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title">Sent At</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        @include('admin.push-notifications.partials.table')
                    </table>
                </div>

                <div id="pagination-wrapper">
                    @include('admin.partials.pagination', ['data' => $notifications])
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
