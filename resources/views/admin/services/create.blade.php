@extends('admin.layout')

@section('title', 'Create Service')
@section('page-title', 'Create New Service')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Service Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="base_price">Base Price *</label>
                <input type="number" id="base_price" name="base_price" class="form-control" value="{{ old('base_price', 0) }}" min="0" step="1000" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="icon">Icon</label>
                <input type="file" id="icon" name="icon" class="form-control" accept="image/*">
                <small style="color: var(--gray); font-size: 0.8125rem;">Max size: 2MB</small>
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    <span class="form-label" style="margin: 0;">Service is Active</span>
                </label>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
