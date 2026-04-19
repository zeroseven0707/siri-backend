<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostComment;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use ApiResponse;

    // GET /posts — feed (semua post, terbaru dulu)
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $posts = Post::with('user')
            ->withCount(['likes as is_liked' => fn($q) => $q->where('user_id', $userId)])
            ->withCount(['saves as is_saved' => fn($q) => $q->where('user_id', $userId)])
            ->latest()
            ->paginate(15);

        return $this->success([
            'posts'      => $posts->map(fn($p) => $this->formatPost($p)),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'per_page'     => $posts->perPage(),
                'total'        => $posts->total(),
            ],
        ]);
    }

    // GET /posts/saved — postingan yang disimpan user
    public function saved(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $posts = Post::with('user')
            ->whereHas('saves', fn($q) => $q->where('user_id', $userId))
            ->withCount(['likes as is_liked' => fn($q) => $q->where('user_id', $userId)])
            ->withCount(['saves as is_saved' => fn($q) => $q->where('user_id', $userId)])
            ->latest()
            ->paginate(15);

        return $this->success([
            'posts'      => $posts->map(fn($p) => $this->formatPost($p)),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'per_page'     => $posts->perPage(),
                'total'        => $posts->total(),
            ],
        ]);
    }

    // GET /posts/{id}/show — detail satu post
    public function show(Request $request, string $id): JsonResponse
    {
        $userId = $request->user()->id;

        $post = Post::with('user')
            ->withCount(['likes as is_liked' => fn($q) => $q->where('user_id', $userId)])
            ->withCount(['saves as is_saved' => fn($q) => $q->where('user_id', $userId)])
            ->find($id);

        if (!$post) return $this->error('Post tidak ditemukan', 404);

        return $this->success($this->formatPost($post));
    }

    // GET /posts/my — postingan milik user sendiri
    public function myPosts(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $posts = Post::with('user')
            ->where('user_id', $userId)
            ->withCount(['likes as is_liked' => fn($q) => $q->where('user_id', $userId)])
            ->withCount(['saves as is_saved' => fn($q) => $q->where('user_id', $userId)])
            ->latest()
            ->paginate(15);

        return $this->success([
            'posts'      => $posts->map(fn($p) => $this->formatPost($p)),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'per_page'     => $posts->perPage(),
                'total'        => $posts->total(),
            ],
        ]);
    }

    // GET /users/{id}/posts — postingan milik user tertentu (public profile)
    public function userPosts(Request $request, string $userId): JsonResponse
    {
        $authUserId = $request->user()->id;

        $posts = Post::with('user')
            ->where('user_id', $userId)
            ->withCount(['likes as is_liked' => fn($q) => $q->where('user_id', $authUserId)])
            ->withCount(['saves as is_saved' => fn($q) => $q->where('user_id', $authUserId)])
            ->latest()
            ->paginate(18);

        return $this->success([
            'posts'      => $posts->map(fn($p) => $this->formatPost($p)),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'per_page'     => $posts->perPage(),
                'total'        => $posts->total(),
            ],
        ]);
    }

    // POST /posts — buat post baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'caption'  => 'nullable|string|max:2200',
            'images'   => 'required_without:image',
            'images.*' => 'image|max:5120',
            'image'    => 'required_without:images|image|max:5120',
        ]);

        $paths = [];

        // Handle images[] array (multiple)
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            // Bisa jadi single file atau array
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $paths[] = $file->store('posts', 'public');
                }
            }
        }

        // Handle image (single, fallback)
        if (empty($paths) && $request->hasFile('image')) {
            $paths[] = $request->file('image')->store('posts', 'public');
        }

        if (empty($paths)) {
            return $this->error('Minimal 1 gambar diperlukan', 422);
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'caption' => $request->caption,
            'images'  => $paths,
        ]);

        $post->load('user');

        return $this->success($this->formatPost($post), 'Post berhasil dibuat', 201);
    }

    // DELETE /posts/{id}
    public function destroy(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);
        if ($post->user_id !== $request->user()->id) return $this->error('Unauthorized', 403);

        foreach ($post->images as $path) {
            Storage::disk('public')->delete($path);
        }

        $post->delete();

        return $this->success(null, 'Post dihapus');
    }

    // POST /posts/{id}/like — toggle like
    public function toggleLike(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);

        $userId = $request->user()->id;
        $like   = $post->likes()->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $userId]);
            $post->increment('likes_count');
            $liked = true;
        }

        return $this->success(['liked' => $liked, 'likes_count' => $post->fresh()->likes_count]);
    }

    // POST /posts/{id}/save — toggle save
    public function toggleSave(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);

        $userId = $request->user()->id;
        $save   = $post->saves()->where('user_id', $userId)->first();

        if ($save) {
            $save->delete();
            $post->decrement('saves_count');
            $saved = false;
        } else {
            $post->saves()->create(['user_id' => $userId]);
            $post->increment('saves_count');
            $saved = true;
        }

        return $this->success(['saved' => $saved, 'saves_count' => $post->fresh()->saves_count]);
    }

    // GET /posts/{id}/comments
    public function comments(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);

        $userId = $request->user()->id;

        $comments = $post->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->paginate(20);

        return $this->success([
            'comments'    => $comments->map(fn($c) => $this->formatComment($c, $userId)),
            'total_count' => \App\Models\PostComment::where('post_id', $id)->count(),
            'pagination'  => [
                'current_page' => $comments->currentPage(),
                'last_page'    => $comments->lastPage(),
                'total'        => $comments->total(),
            ],
        ]);
    }

    // POST /posts/{id}/comments
    public function addComment(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);

        $request->validate([
            'body'      => 'required|string|max:500',
            'parent_id' => 'nullable|uuid|exists:post_comments,id',
        ]);

        $comment = $post->comments()->create([
            'user_id'   => $request->user()->id,
            'parent_id' => $request->parent_id ?? null,
            'body'      => $request->body,
        ]);

        // Increment untuk semua komentar (top-level + reply)
        $post->increment('comments_count');

        $comment->load('user');

        return $this->success($this->formatComment($comment, $request->user()->id), 'Komentar ditambahkan', 201);
    }

    // DELETE /posts/{postId}/comments/{commentId}
    public function deleteComment(Request $request, string $postId, string $commentId): JsonResponse
    {
        $comment = PostComment::find($commentId);
        if (!$comment || $comment->post_id !== $postId) return $this->error('Komentar tidak ditemukan', 404);
        if ($comment->user_id !== $request->user()->id) return $this->error('Unauthorized', 403);

        $comment->delete();
        Post::where('id', $postId)->decrement('comments_count');

        return $this->success(null, 'Komentar dihapus');
    }

    // POST /posts/{id}/report — laporkan post
    public function report(Request $request, string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);
        if ($post->user_id === $request->user()->id) return $this->error('Tidak dapat melaporkan postingan sendiri', 422);

        $request->validate([
            'reason' => 'required|string|in:spam,nudity,hate_speech,violence,false_info,harassment,other',
        ]);

        $already = \DB::table('post_reports')
            ->where('post_id', $id)
            ->where('user_id', $request->user()->id)
            ->exists();

        if ($already) return $this->error('Kamu sudah melaporkan postingan ini', 422);

        \DB::table('post_reports')->insert([
            'post_id'    => $id,
            'user_id'    => $request->user()->id,
            'reason'     => $request->reason,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $this->success(null, 'Laporan berhasil dikirim');
    }

    private function formatComment(\App\Models\PostComment $c, string $userId): array
    {
        return [
            'id'         => $c->id,
            'body'       => $c->body,
            'created_at' => $c->created_at,
            'user'       => [
                'id'              => $c->user->id,
                'name'            => $c->user->name,
                'profile_picture' => $c->user->profile_picture
                    ? asset('storage/' . $c->user->profile_picture)
                    : null,
            ],
            'replies'    => ($c->relationLoaded('replies') ? $c->replies : collect())->map(fn($r) => [
                'id'         => $r->id,
                'body'       => $r->body,
                'created_at' => $r->created_at,
                'user'       => [
                    'id'              => $r->user->id,
                    'name'            => $r->user->name,
                    'profile_picture' => $r->user->profile_picture
                        ? asset('storage/' . $r->user->profile_picture)
                        : null,
                ],
                'replies'    => [],
            ])->values(),
        ];
    }

    private function formatPost(Post $post): array
    {
        return [
            'id'             => $post->id,
            'caption'        => $post->caption,
            'images'         => collect($post->images)->map(fn($p) => asset('storage/' . $p))->values(),
            'likes_count'    => $post->likes_count,
            'comments_count' => $post->comments_count,
            'saves_count'    => $post->saves_count,
            'is_liked'       => (bool) ($post->is_liked ?? false),
            'is_saved'       => (bool) ($post->is_saved ?? false),
            'created_at'     => $post->created_at,
            'user'           => [
                'id'              => $post->user->id,
                'name'            => $post->user->name,
                'profile_picture' => $post->user->profile_picture
                    ? asset('storage/' . $post->user->profile_picture)
                    : null,
            ],
        ];
    }
}
