@extends('admin.layout')
@section('title', 'Users')
@section('page-title', 'Users Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-500">All Users</h6>
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                    <i class="uil uil-plus me-1"></i> Add User
                </a>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search name or email..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-control">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="driver" {{ request('role') === 'driver' ? 'selected' : '' }}>Driver</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div id="table-wrapper" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">#</span></th>
                                <th><span class="userDatatable-title">Name</span></th>
                                <th><span class="userDatatable-title">Phone</span></th>
                                <th><span class="userDatatable-title">Role</span></th>
                                <th><span class="userDatatable-title">Joined</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        @include('admin.users.partials.table')
                    </table>
                </div>

                <div id="pagination-wrapper">
                    @include('admin.partials.pagination', ['data' => $users])
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
