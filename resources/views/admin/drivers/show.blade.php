@extends('admin.layout')
@section('title', 'Detail Driver')
@section('page-title', 'Detail Driver')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.drivers.index') }}">Drivers</a></li>
        <li class="breadcrumb-item active">{{ $driver->name }}</li>
    </ol>
</nav>
@endsection

@section('content')
@if(session('success'))
<div class="alert-custom alert-success-custom mb-20">{{ session('success') }}</div>
@endif

<div class="row">
    {{-- Profile Card --}}
    <div class="col-md-4 mb-25">
        <div class="card h-100">
            <div class="card-body text-center">
                @if($driver->profile_picture)
                    <img src="{{ asset('storage/'.$driver->profile_picture) }}" class="rounded-circle mb-3" width="80" height="80" style="object-fit:cover">
                @else
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold mx-auto mb-3" style="width:80px;height:80px;font-size:28px">
                        {{ strtoupper(substr($driver->name,0,1)) }}
                    </div>
                @endif
                <h5 class="fw-700">{{ $driver->name }}</h5>
                <p class="text-muted mb-1">{{ $driver->email }}</p>
                <p class="text-muted mb-3">{{ $driver->phone ?? '-' }}</p>
                @if($driver->is_active)
                    <span class="badge bg-success fs-12">Aktif</span>
                @else
                    <span class="badge bg-danger fs-12">Nonaktif</span>
                @endif
                <hr>
                <div class="text-start">
                    <p><strong>Kendaraan:</strong> {{ $driver->driverProfile?->vehicle_type ?? '-' }}</p>
                    <p><strong>Plat Nomor:</strong> {{ $driver->driverProfile?->license_plate ?? '-' }}</p>
                    <p><strong>Bergabung:</strong> {{ $driver->created_at->format('d M Y') }}</p>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <form method="POST" action="{{ route('admin.drivers.toggle-active', $driver) }}" class="flex-fill">
                        @csrf
                        <button type="submit" class="btn w-100 {{ $driver->is_active ? 'btn-warning' : 'btn-success' }}">
                            {{ $driver->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="col-md-8 mb-25">
        <div class="row">
            <div class="col-6 mb-3">
                <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
                    <h3 class="color-primary">{{ $completedCount }}</h3>
                    <p class="text-muted">Pesanan Selesai</p>
                </div>
            </div>
            <div class="col-6 mb-3">
                <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
                    <h3 style="color:#10B981">Rp {{ number_format($earnings,0,',','.') }}</h3>
                    <p class="text-muted">Total Pendapatan</p>
                </div>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Riwayat Pesanan</h6></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th>Pelanggan</th><th>Layanan</th><th>Ongkir</th><th>Status</th><th>Tanggal</th></tr>
                        </thead>
                        <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->user?->name ?? '-' }}</td>
                            <td>{{ $order->service?->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->delivery_fee ?? 0,0,',','.') }}</td>
                            <td>
                                @php $colors = ['pending'=>'warning','accepted'=>'info','on_progress'=>'primary','completed'=>'success','cancelled'=>'danger']; @endphp
                                <span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">{{ $order->status }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-3">Belum ada pesanan</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-3">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
