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

    // POST /posts — buat post baru
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'caption'  => 'nullable|string|max:2200',
            'images'   => 'required|array|min:1|max:10',
            'images.*' => 'required|image|max:5120', // max 5MB per gambar
        ]);

        $paths = [];
        foreach ($request->file('images') as $file) {
            $paths[] = $file->store('posts', 'public');
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
    public function comments(string $id): JsonResponse
    {
        $post = Post::find($id);
        if (!$post) return $this->error('Post tidak ditemukan', 404);

        $comments = $post->comments()->with('user')->paginate(20);

        return $this->success([
            'comments'   => $comments->map(fn($c) => [
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
            ]),
            'pagination' => [
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

        $request->validate(['body' => 'required|string|max:500']);

        $comment = $post->comments()->create([
            'user_id' => $request->user()->id,
            'body'    => $request->body,
        ]);

        $post->increment('comments_count');
        $comment->load('user');

        return $this->success([
            'id'         => $comment->id,
            'body'       => $comment->body,
            'created_at' => $comment->created_at,
            'user'       => [
                'id'              => $comment->user->id,
                'name'            => $comment->user->name,
                'profile_picture' => $comment->user->profile_picture
                    ? asset('storage/' . $comment->user->profile_picture)
                    : null,
            ],
        ], 'Komentar ditambahkan', 201);
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
