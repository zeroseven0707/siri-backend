<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index(Request $request)
    {
        $query = HomeSection::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sections = $query->orderBy('order')->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.home-sections.partials.table', compact('sections'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $sections])->render(),
            ]);
        }

        return view('admin.home-sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.home-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:banner,category,featured,promotion',
            'image' => 'nullable|image|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        }

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section created successfully');
    }

    public function edit(HomeSection $homeSection)
    {
        return view('admin.home-sections.edit', compact('homeSection'));
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'type' => 'required|in:banner,category,featured,promotion',
            'image' => 'nullable|image|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($homeSection->image) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = $request->file('image')->store('home-sections', 'public');
        }

        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section updated successfully');
    }

    public function destroy(HomeSection $homeSection)
    {
        if ($homeSection->image) {
            Storage::disk('public')->delete($homeSection->image);
        }

        $homeSection->delete();

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section deleted successfully');
    }
}
