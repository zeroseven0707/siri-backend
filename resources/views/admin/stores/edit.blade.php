@extends('admin.layout')
@section('title', 'Edit Store')
@section('page-title', 'Edit Store')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-edit me-2"></i>Edit Store: {{ $store->name }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.stores.update', $store) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="name">Store Name <span class="color-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $store->name) }}" placeholder="Enter store name" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter store description">{{ old('description', $store->description) }}</textarea>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="address">Address <span class="color-danger">*</span></label>
                        <textarea id="address" name="address" class="form-control" rows="2" placeholder="Enter store address" required>{{ old('address', $store->address) }}</textarea>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="phone">Phone Number <span class="color-danger">*</span></label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $store->phone) }}" placeholder="+62..." required>
                    </div>
                    @if($store->image)
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Current Image</label>
                        <img src="{{ asset('storage/' . $store->image) }}" class="rounded" style="max-width:150px; max-height:150px; object-fit:cover;">
                    </div>
                    @endif
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">{{ $store->image ? 'Change Image' : 'Store Image' }}</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <small class="fs-12 color-light mt-5 d-block">Max size: 2MB</small>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Status</label>
                        <div class="checkbox-theme-default custom-checkbox check-all">
                            <input class="checkbox" type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', $store->is_open) ? 'checked' : '' }}>
                            <label for="is_open">
                                <span class="checkbox-text">Store is Open</span>
                            </label>
                        </div>
                    </div>
                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-check me-1"></i> Update Store
                        </button>
                        <a href="{{ route('admin.stores.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
