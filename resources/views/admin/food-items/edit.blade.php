@extends('admin.layout')
@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.food-items.index') }}">Menu Makanan</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.food-items.update', $foodItem) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Toko <span class="text-danger">*</span></label>
                <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @selected(old('store_id', $foodItem->store_id) === $store->id)>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $foodItem->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Harga <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $foodItem->price) }}" min="0" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $foodItem->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                @if($foodItem->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$foodItem->image) }}" height="80" style="border-radius:8px">
                    </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" @checked(old('is_available', $foodItem->is_available))>
                <label class="form-check-label" for="is_available">Tersedia</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.food-items.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
