@extends('admin.layout')
@section('title', 'Create Home Section')
@section('page-title', 'Create New Home Section')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.home-sections.index') }}">Home Sections</a></li>
        <li class="breadcrumb-item active">Create</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-apps me-2"></i>Create New Home Section</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.home-sections.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="title">Title <span class="color-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Enter section title" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="key">Key (Slug) <span class="color-danger">*</span></label>
                        <input type="text" id="key" name="key" class="form-control" value="{{ old('key') }}" placeholder="e.g. popular_stores" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="type">Type <span class="color-danger">*</span></label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="banner" {{ old('type') === 'banner' ? 'selected' : '' }}>Banner</option>
                            <option value="store_list" {{ old('type') === 'store_list' ? 'selected' : '' }}>Store List</option>
                            <option value="food_list" {{ old('type') === 'food_list' ? 'selected' : '' }}>Food List</option>
                            <option value="service_list" {{ old('type') === 'service_list' ? 'selected' : '' }}>Service List</option>
                            <option value="promo" {{ old('type') === 'promo' ? 'selected' : '' }}>Promo</option>
                            <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Status</label>
                        <div class="checkbox-theme-default custom-checkbox check-all">
                            <input class="checkbox" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active">
                                <span class="checkbox-text">Section is Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-check me-1"></i> Create Section
                        </button>
                        <a href="{{ route('admin.home-sections.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
