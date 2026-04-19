@extends('admin.layout')
@section('title', 'Laporan Konten')
@section('page-title', 'Laporan Konten')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
        <li class="breadcrumb-item active">Laporan</li>
    </ol>
</nav>
@endsection

@section('content')
@if(session('success'))
<div class="alert-custom alert-success-custom mb-20">{{ session('success') }}</div>
@endif

{{-- Reason breakdown --}}
<div class="row mb-25">
    @foreach($reasonCounts as $reason => $count)
    <div class="col-md-2 col-sm-4 mb-3">
        <div class="ap-po-details p-15 radius-xl text-center">
            <h4>{{ $count }}</h4>
            <small class="text-muted">{{ str_replace('_',' ', $reason) }}</small>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex gap-2 mb-20">
    <form method="GET" class="d-flex gap-2">
        <select name="reason" class="form-select">
            <option value="">Semua Alasan</option>
            @foreach(['spam','nudity','hate_speech','violence','false_info','harassment','other'] as $r)
                <option value="{{ $r }}" @selected(request('reason') === $r)>{{ str_replace('_',' ', $r) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.posts.reports') }}" class="btn btn-secondary">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Post</th>
                        <th>Penulis</th>
                        <th>Pelapor</th>
                        <th>Alasan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>
                        @php $images = json_decode($report->images, true) ?? []; @endphp
                        @if(count($images))
                            <img src="{{ asset('storage/'.$images[0]) }}" width="50" height="50" style="object-fit:cover;border-radius:8px">
                        @endif
                        <div class="mt-1"><small>{{ Str::limit($report->caption, 40) ?? '-' }}</small></div>
                    </td>
                    <td>{{ $report->author_name }}</td>
                    <td>{{ $report->reporter_name }}</td>
                    <td><span class="badge bg-warning text-dark">{{ str_replace('_',' ', $report->reason) }}</span></td>
                    <td>{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.posts.show', $report->post_id) }}" class="btn btn-sm btn-outline-primary">Tinjau</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada laporan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $reports->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
