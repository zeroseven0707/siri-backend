@extends('admin.layout')
@section('title', 'Driver Management')
@section('page-title', 'Driver Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Drivers</li>
    </ol>
</nav>
@endsection

@section('content')
@if(session('success'))
<div class="alert-custom alert-success-custom mb-20">{{ session('success') }}</div>
@endif

{{-- Stats --}}
<div class="row mb-25">
    <div class="col-md-4">
        <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
            <h2 class="color-primary">{{ $stats['total'] }}</h2>
            <p class="text-muted">Total Driver</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
            <h2 style="color:#10B981">{{ $stats['active'] }}</h2>
            <p class="text-muted">Driver Aktif</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
            <h2 style="color:#EF4444">{{ $stats['inactive'] }}</h2>
            <p class="text-muted">Driver Nonaktif</p>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card mb-25">
    <div class="card-body">
        <form method="GET" class="d-flex gap-3 flex-wrap align-items-end">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-control" placeholder="Nama, email, telepon..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="active" @selected(request('status') === 'active')>Aktif</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Driver</th>
                        <th>Telepon</th>
                        <th>Kendaraan</th>
                        <th>Plat</th>
                        <th>Status</th>
                        <th>Pesanan Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($drivers as $driver)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($driver->profile_picture)
                                <img src="{{ asset('storage/'.$driver->profile_picture) }}" class="rounded-circle" width="36" height="36" style="object-fit:cover">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width:36px;height:36px;font-size:14px">
                                    {{ strtoupper(substr($driver->name,0,1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-600">{{ $driver->name }}</div>
                                <small class="text-muted">{{ $driver->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $driver->phone ?? '-' }}</td>
                    <td>{{ $driver->driverProfile?->vehicle_type ?? '-' }}</td>
                    <td>{{ $driver->driverProfile?->license_plate ?? '-' }}</td>
                    <td>
                        @if($driver->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ \App\Models\Order::where('driver_id',$driver->id)->where('status','completed')->count() }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.drivers.show', $driver) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <form method="POST" action="{{ route('admin.drivers.toggle-active', $driver) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $driver->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                    {{ $driver->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.drivers.destroy', $driver) }}" onsubmit="return confirm('Hapus driver ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada driver ditemukan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $drivers->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
