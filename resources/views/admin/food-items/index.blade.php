@extends('admin.layout')
@section('title', 'Menu Makanan')
@section('page-title', 'Menu Makanan')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Menu Makanan</li>
    </ol>
</nav>
@endsection

@section('content')
@if(session('success'))
<div class="alert-custom alert-success-custom mb-20">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-20">
    <form method="GET" class="d-flex gap-2 flex-wrap">
        <input type="text" name="search" class="form-control" placeholder="Cari nama menu..." value="{{ request('search') }}" style="width:220px">
        <select name="store_id" class="form-select" style="width:200px">
            <option value="">Semua Toko</option>
            @foreach($stores as $store)
                <option value="{{ $store->id }}" @selected(request('store_id') === $store->id)>{{ $store->name }}</option>
            @endforeach
        </select>
        <select name="available" class="form-select" style="width:160px">
            <option value="">Semua Status</option>
            <option value="1" @selected(request('available') === '1')>Tersedia</option>
            <option value="0" @selected(request('available') === '0')>Tidak Tersedia</option>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.food-items.index') }}" class="btn btn-secondary">Reset</a>
    </form>
    <a href="{{ route('admin.food-items.create') }}" class="btn btn-primary">
        <i class="uil uil-plus"></i> Tambah Menu
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Toko</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($foods as $food)
                <tr>
                    <td>
                        @if($food->image)
                            <img src="{{ asset('storage/'.$food->image) }}" width="50" height="50" style="object-fit:cover;border-radius:8px">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;border-radius:8px">🍱</div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-600">{{ $food->name }}</div>
                        @if($food->description)
                            <small class="text-muted">{{ Str::limit($food->description, 50) }}</small>
                        @endif
                    </td>
                    <td>{{ $food->store?->name ?? '-' }}</td>
                    <td>Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                    <td>
                        @if($food->is_available)
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-secondary">Tidak Tersedia</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.food-items.edit', $food) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.food-items.toggle-available', $food) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $food->is_available ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                    {{ $food->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.food-items.destroy', $food) }}" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada menu ditemukan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $foods->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
