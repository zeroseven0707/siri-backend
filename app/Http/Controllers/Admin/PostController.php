<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('user');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('caption', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $posts = $query->latest()->paginate(20)->withQueryString();

        // Laporan yang belum ditangani
        $reportedPostIds = DB::table('post_reports')
            ->select('post_id', DB::raw('count(*) as report_count'))
            ->groupBy('post_id')
            ->pluck('report_count', 'post_id');

        $stats = [
            'total'    => Post::count(),
            'reported' => DB::table('post_reports')->distinct('post_id')->count('post_id'),
            'total_reports' => DB::table('post_reports')->count(),
        ];

        return view('admin.posts.index', compact('posts', 'reportedPostIds', 'stats'));
    }

    public function show(Post $post)
    {
        $post->load('user');

        $reports = DB::table('post_reports')
            ->join('users', 'users.id', '=', 'post_reports.user_id')
            ->where('post_reports.post_id', $post->id)
            ->select('post_reports.*', 'users.name as reporter_name', 'users.email as reporter_email')
            ->get();

        return view('admin.posts.show', compact('post', 'reports'));
    }

    public function destroy(Post $post)
    {
        foreach ($post->images as $path) {
            Storage::disk('public')->delete($path);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus.');
    }

    public function reports(Request $request)
    {
        $reports = DB::table('post_reports')
            ->join('posts', 'posts.id', '=', 'post_reports.post_id')
            ->join('users as reporters', 'reporters.id', '=', 'post_reports.user_id')
            ->join('users as authors', 'authors.id', '=', 'posts.user_id')
            ->select(
                'post_reports.*',
                'posts.caption',
                'posts.images',
                'reporters.name as reporter_name',
                'authors.name as author_name'
            )
            ->when($request->filled('reason'), fn($q) => $q->where('post_reports.reason', $request->reason))
            ->orderByDesc('post_reports.created_at')
            ->paginate(20)
            ->withQueryString();

        $reasonCounts = DB::table('post_reports')
            ->select('reason', DB::raw('count(*) as total'))
            ->groupBy('reason')
            ->pluck('total', 'reason');

        return view('admin.posts.reports', compact('reports', 'reasonCounts'));
    }

    public function dismissReports(Request $request, string $postId)
    {
        DB::table('post_reports')->where('post_id', $postId)->delete();
        return redirect()->back()->with('success', 'Laporan untuk postingan ini telah dihapus.');
    }
}
