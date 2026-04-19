@extends('admin.layout')
@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.food-items.index') }}">Menu Makanan</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.food-items.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Toko <span class="text-danger">*</span></label>
                <select name="store_id" class="form-select @error('store_id') is-invalid @enderror" required>
                    <option value="">Pilih Toko</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" @selected(old('store_id') === $store->id)>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Harga <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" min="0" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" @checked(old('is_available', true))>
                <label class="form-check-label" for="is_available">Tersedia</label>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.food-items.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
