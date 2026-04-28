@extends('admin.layout')
@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.services.index') }}">Services</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-edit me-2"></i>Edit Service: {{ $service->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="name">Service Name <span class="color-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $service->name) }}" placeholder="Enter service name" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter service description">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="vehicle_type">Vehicle Type <span class="color-danger">*</span></label>
                        <select id="vehicle_type" name="vehicle_type" class="form-control @error('vehicle_type') is-invalid @enderror" required>
                            <option value="">Select Vehicle Type</option>
                            <option value="motor" {{ old('vehicle_type', $service->vehicle_type) == 'motor' ? 'selected' : '' }}>Motor (Bike/Motorcycle)</option>
                            <option value="mobil" {{ old('vehicle_type', $service->vehicle_type) == 'mobil' ? 'selected' : '' }}>Mobil (Car)</option>
                        </select>
                        @error('vehicle_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="fs-12 color-light mt-5 d-block">Motor for food delivery & bike rides, Mobil for car rides</small>
                    </div>

                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="base_price">Base Price (Rp) <span class="color-danger">*</span></label>
                        <input type="number" id="base_price" name="base_price" class="form-control @error('base_price') is-invalid @enderror" value="{{ old('base_price', $service->base_price) }}" min="0" step="1000" required>
                        @error('base_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Status</label>
                        <div class="checkbox-theme-default custom-checkbox check-all">
                            <input class="checkbox" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label for="is_active">
                                <span class="checkbox-text">Service is Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-check me-1"></i> Update Service
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
