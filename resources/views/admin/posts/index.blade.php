@extends('admin.layout')
@section('title', 'Post Management')
@section('page-title', 'Post Management')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Posts</li>
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
            <p class="text-muted">Total Postingan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
            <h2 style="color:#EF4444">{{ $stats['reported'] }}</h2>
            <p class="text-muted">Post Dilaporkan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ap-po-details ap-po-details--2 p-20 radius-xl">
            <h2 style="color:#F59E0B">{{ $stats['total_reports'] }}</h2>
            <p class="text-muted">Total Laporan</p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-20">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Cari caption atau nama user..." value="{{ request('search') }}" style="width:300px">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Reset</a>
    </form>
    <a href="{{ route('admin.posts.reports') }}" class="btn btn-outline-danger">
        <i class="uil uil-flag"></i> Lihat Laporan
        @if($stats['total_reports'] > 0)
            <span class="badge bg-danger ms-1">{{ $stats['total_reports'] }}</span>
        @endif
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Pengguna</th>
                        <th>Caption</th>
                        <th>Likes</th>
                        <th>Komentar</th>
                        <th>Laporan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                <tr @if(isset($reportedPostIds[$post->id])) style="background:#fff5f5" @endif>
                    <td>
                        @if(count($post->images))
                            <img src="{{ asset('storage/'.$post->images[0]) }}" width="50" height="50" style="object-fit:cover;border-radius:8px">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:50px;border-radius:8px">
                                <i class="uil uil-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="fw-600">{{ $post->user->name }}</div>
                        <small class="text-muted">{{ $post->user->email }}</small>
                    </td>
                    <td>
                        <span title="{{ $post->caption }}">{{ Str::limit($post->caption, 60) ?? '-' }}</span>
                        @if(count($post->images) > 1)
                            <span class="badge bg-secondary ms-1">+{{ count($post->images)-1 }} foto</span>
                        @endif
                    </td>
                    <td>{{ $post->likes_count }}</td>
                    <td>{{ $post->comments_count }}</td>
                    <td>
                        @if(isset($reportedPostIds[$post->id]))
                            <span class="badge bg-danger">{{ $reportedPostIds[$post->id] }} laporan</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus postingan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada postingan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $posts->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
