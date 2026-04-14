@extends('admin.layout')

@section('title', 'Edit Store')
@section('page-title', 'Edit Store')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.stores.update', $store) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="name">Store Name *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $store->name) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    rows="3"
                >{{ old('description', $store->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Address *</label>
                <textarea
                    id="address"
                    name="address"
                    class="form-control"
                    rows="2"
                    required
                >{{ old('address', $store->address) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number *</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone', $store->phone) }}"
                    required
                >
            </div>

            @if($store->image)
                <div class="form-group">
                    <label class="form-label">Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $store->image) }}" alt="{{ $store->name }}" style="max-width: 200px; border-radius: 8px;">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label" for="image">{{ $store->image ? 'Change Image' : 'Store Image' }}</label>
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
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input
                        type="checkbox"
                        name="is_open"
                        value="1"
                        {{ old('is_open', $store->is_open) ? 'checked' : '' }}
                        style="width: 18px; height: 18px;"
                    >
                    <span class="form-label" style="margin: 0;">Store is Open</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Update Store</button>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
