@extends('admin.layout')

@section('title', 'Create Home Section')
@section('page-title', 'Create New Home Section')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.home-sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="title">Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="subtitle">Subtitle</label>
                <input
                    type="text"
                    id="subtitle"
                    name="subtitle"
                    class="form-control"
                    value="{{ old('subtitle') }}"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="type">Type *</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="banner" {{ old('type') === 'banner' ? 'selected' : '' }}>Banner</option>
                    <option value="category" {{ old('type') === 'category' ? 'selected' : '' }}>Category</option>
                    <option value="featured" {{ old('type') === 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="promotion" {{ old('type') === 'promotion' ? 'selected' : '' }}>Promotion</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Image</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-control"
                    accept="image/*"
                >
                <small style="color: var(--gray); font-size: 0.8125rem;">Max size: 2MB</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="order">Display Order *</label>
                <input
                    type="number"
                    id="order"
                    name="order"
                    class="form-control"
                    value="{{ old('order', 0) }}"
                    min="0"
                    required
                >
                <small style="color: var(--gray); font-size: 0.8125rem;">Lower numbers appear first</small>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        style="width: 18px; height: 18px;"
                    >
                    <span class="form-label" style="margin: 0;">Section is Active</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create Section</button>
                <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
