@extends('admin.layout')
@section('title', 'Edit Home Section')
@section('page-title', 'Edit Home Section')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="uil uil-estate"></i>Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.home-sections.index') }}">Home Sections</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="fw-500"><i class="uil uil-edit me-2"></i>Edit Section: {{ $homeSection->title }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="title">Title <span class="color-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $homeSection->title) }}" placeholder="Enter section title" required>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control" value="{{ old('subtitle', $homeSection->subtitle) }}" placeholder="Enter section subtitle">
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="type">Type <span class="color-danger">*</span></label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="banner" {{ old('type', $homeSection->type) === 'banner' ? 'selected' : '' }}>Banner</option>
                            <option value="category" {{ old('type', $homeSection->type) === 'category' ? 'selected' : '' }}>Category</option>
                            <option value="featured" {{ old('type', $homeSection->type) === 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="promotion" {{ old('type', $homeSection->type) === 'promotion' ? 'selected' : '' }}>Promotion</option>
                        </select>
                    </div>
                    @if($homeSection->image)
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Current Image</label>
                        <img src="{{ asset('storage/' . $homeSection->image) }}" class="rounded" style="max-width:150px; max-height:150px; object-fit:cover;">
                    </div>
                    @endif
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">{{ $homeSection->image ? 'Change Image' : 'Image' }}</label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                        <small class="fs-12 color-light mt-5 d-block">Max size: 2MB</small>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10" for="order">Display Order <span class="color-danger">*</span></label>
                        <input type="number" id="order" name="order" class="form-control" value="{{ old('order', $homeSection->order) }}" min="0" required>
                        <small class="fs-12 color-light mt-5 d-block">Lower numbers appear first</small>
                    </div>
                    <div class="form-group mb-20">
                        <label class="color-dark fs-14 fw-500 align-center mb-10">Status</label>
                        <div class="checkbox-theme-default custom-checkbox check-all">
                            <input class="checkbox" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}>
                            <label for="is_active">
                                <span class="checkbox-text">Section is Active</span>
                            </label>
                        </div>
                    </div>
                    <div class="button-group d-flex pt-25">
                        <button type="submit" class="btn btn-primary btn-default btn-squared text-capitalize">
                            <i class="uil uil-check me-1"></i> Update Section
                        </button>
                        <a href="{{ route('admin.home-sections.index') }}" class="btn btn-light btn-default btn-squared text-capitalize ms-15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
