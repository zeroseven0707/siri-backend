@extends('admin.layout')
@section('title', 'Detail Post')
@section('page-title', 'Detail Post')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
</nav>
@endsection

@section('content')
<div class="row">
    <div class="col-md-7 mb-25">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    @if($post->user->profile_picture)
                        <img src="{{ asset('storage/'.$post->user->profile_picture) }}" class="rounded-circle" width="36" height="36" style="object-fit:cover">
                    @else
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width:36px;height:36px">
                            {{ strtoupper(substr($post->user->name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="fw-600">{{ $post->user->name }}</div>
                        <small class="text-muted">{{ $post->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Hapus postingan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus Post</button>
                </form>
            </div>
            <div class="card-body p-0">
                @foreach($post->images as $img)
                    <img src="{{ asset('storage/'.$img) }}" class="w-100" style="max-height:400px;object-fit:cover">
                @endforeach
                @if($post->caption)
                    <div class="p-3">
                        <p class="mb-0">{{ $post->caption }}</p>
                    </div>
                @endif
            </div>
            <div class="card-footer d-flex gap-4">
                <span><i class="uil uil-heart"></i> {{ $post->likes_count }} suka</span>
                <span><i class="uil uil-comment"></i> {{ $post->comments_count }} komentar</span>
                <span><i class="uil uil-bookmark"></i> {{ $post->saves_count }} simpan</span>
            </div>
        </div>
    </div>

    <div class="col-md-5 mb-25">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Laporan ({{ count($reports) }})</h6>
                @if(count($reports) > 0)
                <form method="POST" action="{{ route('admin.posts.dismiss-reports', $post->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary">Hapus Semua Laporan</button>
                </form>
                @endif
            </div>
            <div class="card-body p-0">
                @forelse($reports as $report)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $report->reporter_name }}</strong>
                        <span class="badge bg-warning text-dark">{{ str_replace('_',' ', $report->reason) }}</span>
                    </div>
                    <small class="text-muted">{{ $report->reporter_email }}</small><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($report->created_at)->format('d M Y H:i') }}</small>
                </div>
                @empty
                <div class="p-3 text-center text-muted">Tidak ada laporan</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
