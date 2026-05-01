@extends('admin.layout')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-edit me-2"></i>Edit User: {{ $user->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="name">Full Name <span class="color-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="email">Email Address <span class="color-danger">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="+62...">
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                        <small class="fs-12 color-light mt-5 d-block">Leave blank to keep the current password</small>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="role">Role <span class="color-danger">*</span></label>
                        <select id="role" name="role" class="form-control" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="driver" {{ old('role', $user->role) === 'driver' ? 'selected' : '' }}>Driver</option>
                        </select>
                    </div>

                    <div id="driver-fields" style="display: none;">
                        <div class="form-group mb-20">
                            <label class="color-dark fs-14 fw-500 align-center mb-10" for="vehicle_type">Vehicle Type <span class="color-danger">*</span></label>
                            <input type="text" id="vehicle_type" name="vehicle_type" class="form-control" value="{{ old('vehicle_type', $user->driverProfile?->vehicle_type) }}" placeholder="e.g. Motorcycle, Car">
                        </div>
                        <div class="form-group mb-20">
                            <label class="color-dark fs-14 fw-500 align-center mb-10" for="license_plate">License Plate <span class="color-danger">*</span></label>
                            <input type="text" id="license_plate" name="license_plate" class="form-control" value="{{ old('license_plate', $user->driverProfile?->license_plate) }}" placeholder="e.g. B 1234 ABC">
                        </div>
                    </div>

                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-check-circle me-1"></i> Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const driverFields = document.getElementById('driver-fields');
        const vehicleInput = document.getElementById('vehicle_type');
        const licenseInput = document.getElementById('license_plate');

        function toggleDriverFields() {
            if (roleSelect.value === 'driver') {
                driverFields.style.display = 'block';
                vehicleInput.setAttribute('required', 'required');
                licenseInput.setAttribute('required', 'required');
            } else {
                driverFields.style.display = 'none';
                vehicleInput.removeAttribute('required');
                licenseInput.removeAttribute('required');
            }
        }

        roleSelect.addEventListener('change', toggleDriverFields);
        toggleDriverFields(); // Initial check
    });
</script>
@endpush
