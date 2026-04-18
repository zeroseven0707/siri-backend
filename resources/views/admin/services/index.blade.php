@extends('admin.layout')
@section('title', 'Services')
@section('page-title', 'Services Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item active">Services</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 mb-30">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-500">All Services</h6>
                <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary">
                    <i class="uil uil-plus me-1"></i> Add Service
                </a>
            </div>
            <div class="card-body">
                <form id="filter-form" class="mb-20">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Search services..." value="{{ request('search') }}">
                        </div>
                    </div>
                </form>

                <div id="table-wrapper" class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr class="userDatatable-header">
                                <th><span class="userDatatable-title">#</span></th>
                                <th><span class="userDatatable-title">Name</span></th>
                                <th><span class="userDatatable-title">Base Price</span></th>
                                <th><span class="userDatatable-title">Status</span></th>
                                <th><span class="userDatatable-title">Created</span></th>
                                <th><span class="userDatatable-title text-end">Actions</span></th>
                            </tr>
                        </thead>
                        @include('admin.services.partials.table')
                    </table>
                </div>

                <div id="pagination-wrapper">
                    @include('admin.partials.pagination', ['data' => $services])
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
