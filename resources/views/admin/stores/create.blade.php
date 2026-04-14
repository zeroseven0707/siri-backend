@extends('admin.layout')

@section('title', 'Create Store')
@section('page-title', 'Create New Store')

@section('content')
    <div class="card" style="max-width: 700px;">
        <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label" for="name">Store Name *</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
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
                >{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="address">Address *</label>
                <textarea
                    id="address"
                    name="address"
                    class="form-control"
                    rows="2"
                    required
                >{{ old('address') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone Number *</label>
                <input
                    type="text"
                    id="phone"
                    name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    placeholder="+62"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="image">Store Image</label>
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
                        {{ old('is_open', true) ? 'checked' : '' }}
                        style="width: 18px; height: 18px;"
                    >
                    <span class="form-label" style="margin: 0;">Store is Open</span>
                </label>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">Create Store</button>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
