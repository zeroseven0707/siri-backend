<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $post->user->name }} di Push App</title>

  {{-- Open Graph / WhatsApp / Telegram preview --}}
  <meta property="og:title" content="{{ $post->user->name }} di Push App" />
  <meta property="og:description" content="{{ $post->caption ?? 'Lihat postingan ini di Push App' }}" />
  @if(count($post->images))
  <meta property="og:image" content="{{ asset('storage/' . $post->images[0]) }}" />
  @endif
  <meta property="og:url" content="{{ url('/post/' . $post->id) }}" />
  <meta property="og:type" content="article" />

  {{-- Twitter Card --}}
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $post->user->name }} di Push App" />
  <meta name="twitter:description" content="{{ $post->caption ?? 'Lihat postingan ini di Push App' }}" />
  @if(count($post->images))
  <meta name="twitter:image" content="{{ asset('storage/' . $post->images[0]) }}" />
  @endif

  {{-- Deep link ke app --}}
  <meta http-equiv="refresh" content="2;url=Push://post/{{ $post->id }}" />

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f9fafb; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .card { background: #fff; border-radius: 20px; overflow: hidden; max-width: 420px; width: 100%; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    .card-header { display: flex; align-items: center; gap: 12px; padding: 16px; }
    .avatar { width: 42px; height: 42px; border-radius: 50%; background: #2ECC71; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 18px; overflow: hidden; flex-shrink: 0; }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .username { font-weight: 700; font-size: 14px; color: #111827; }
    .time { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
    .post-image { width: 100%; aspect-ratio: 1; object-fit: cover; display: block; background: #f3f4f6; }
    .caption { padding: 14px 16px; font-size: 14px; color: #374151; line-height: 1.5; }
    .stats { display: flex; gap: 16px; padding: 0 16px 14px; font-size: 13px; color: #6B7280; }
    .open-btn { display: block; margin: 0 16px 20px; background: #2ECC71; color: #fff; text-align: center; padding: 13px; border-radius: 14px; font-weight: 700; font-size: 15px; text-decoration: none; }
    .hint { text-align: center; font-size: 12px; color: #9CA3AF; padding-bottom: 16px; }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">
      <div class="avatar">
        @if($post->user->profile_picture)
          <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="{{ $post->user->name }}" />
        @else
          {{ strtoupper(substr($post->user->name, 0, 1)) }}
        @endif
      </div>
      <div>
        <div class="username">{{ $post->user->name }}</div>
        <div class="time">{{ $post->created_at->diffForHumans() }}</div>
      </div>
    </div>

    @if(count($post->images))
      <img class="post-image" src="{{ asset('storage/' . $post->images[0]) }}" alt="Post image" />
    @endif

    @if($post->caption)
      <div class="caption">{{ $post->caption }}</div>
    @endif

    <div class="stats">
      <span>❤️ {{ $post->likes_count }}</span>
      <span>💬 {{ $post->comments_count }}</span>
    </div>

    <a class="open-btn" href="Push://post/{{ $post->id }}">Buka di Push App</a>
    <div class="hint">Mengarahkan ke app secara otomatis...</div>
  </div>

  <script>
    // Coba buka deep link, fallback tetap di halaman ini
    setTimeout(function() {
      window.location.href = 'Push://post/{{ $post->id }}';
    }, 500);
  </script>
</body>
</html>
