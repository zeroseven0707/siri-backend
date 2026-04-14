@extends('admin.layout')

@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label" for="name">Service Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="base_price">Base Price *</label>
                <input type="number" id="base_price" name="base_price" class="form-control" value="{{ old('base_price', $service->base_price) }}" min="0" step="1000" required>
            </div>
            @if($service->icon)
                <div class="form-group">
                    <label class="form-label">Current Icon</label>
                    <div><img src="{{ asset('storage/' . $service->icon) }}" alt="{{ $service->name }}" style="max-width: 100px; border-radius: 8px;"></div>
                </div>
            @endif
            <div class="form-group">
                <label class="form-label" for="icon">{{ $service->icon ? 'Change Icon' : 'Icon' }}</label>
                <input type="file" id="icon" name="icon" class="form-control" accept="image/*">
                <small style="color: var(--gray); font-size: 0.8125rem;">Max size: 2MB</small>
            </div>
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                    <span class="form-label" style="margin: 0;">Service is Active</span>
                </label>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Service</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
