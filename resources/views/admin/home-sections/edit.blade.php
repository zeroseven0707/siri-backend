@extends('admin.layout')

@section('title', 'Edit Home Section')
@section('page-title', 'Edit Home Section')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.home-sections.update', $homeSection) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="title">Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $homeSection->title) }}"
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
                    value="{{ old('subtitle', $homeSection->subtitle) }}"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="type">Type *</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="banner" {{ old('type', $homeSection->type) === 'banner' ? 'selected' : '' }}>Banner</option>
                    <option value="category" {{ old('type', $homeSection->type) === 'category' ? 'selected' : '' }}>Category</option>
                    <option value="featured" {{ old('type', $homeSection->type) === 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="promotion" {{ old('type', $homeSection->type) === 'promotion' ? 'selected' : '' }}>Promotion</option>
                </select>
            </div>

            @if($homeSection->image)
                <div class="form-group">
                    <label class="form-label">Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $homeSection->image) }}" alt="{{ $homeSection->title }}" style="max-width: 200px; border-radius: 8px;">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label" for="image">{{ $homeSection->image ? 'Change Image' : 'Image' }}</label>
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
                    value="{{ old('order', $homeSection->order) }}"
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
                        {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}
                        style="width: 18px; height: 18px;"
                    >
                    <span class="form-label" style="margin: 0;">Section is Active</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Section</button>
                <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
