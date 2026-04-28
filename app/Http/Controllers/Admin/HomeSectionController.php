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

        $sections = $query->orderBy('order')->paginate(100)->withQueryString();

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
            'key' => 'required|string|max:255|unique:home_sections,key',
            'type' => 'required|in:banner,store_list,food_list,service_list,promo,custom',
            'is_active' => 'boolean',
        ]);

        $validated['order'] = HomeSection::max('order') + 1;

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Home section created successfully');
    }

    public function edit(HomeSection $homeSection)
    {
        $homeSection->load('items');
        $stores = \App\Models\Store::orderBy('name')->get();
        $foodItems = \App\Models\FoodItem::orderBy('name')->get();
        $services = \App\Models\Service::orderBy('name')->get();

        return view('admin.home-sections.edit', compact('homeSection', 'stores', 'foodItems', 'services'));
    }

    public function addItem(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'action_type' => 'required|in:route,url,store,food,service',
            'action_value' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home-sections/items', 'public');
        } else {
            // Auto-fill from target if image is not provided
            if ($validated['action_type'] === 'store') {
                $target = \App\Models\Store::find($validated['action_value']);
                if ($target) {
                    $validated['image'] = $target->image;
                    $validated['title'] = $validated['title'] ?: $target->name;
                    $validated['subtitle'] = $validated['subtitle'] ?: $target->address;
                }
            } elseif ($validated['action_type'] === 'food') {
                $target = \App\Models\FoodItem::find($validated['action_value']);
                if ($target) {
                    $validated['image'] = $target->image;
                    $validated['title'] = $validated['title'] ?: $target->name;
                    $validated['subtitle'] = $validated['subtitle'] ?: 'Rp ' . number_format($target->price, 0, ',', '.');
                }
            } elseif ($validated['action_type'] === 'service') {
                // action_value contains service slug (not UUID)
                $target = \App\Models\Service::where('slug', $validated['action_value'])->first();
                if ($target) {
                    $validated['title'] = $validated['title'] ?: $target->name;
                    $validated['subtitle'] = $validated['subtitle'] ?: $target->description;
                    // Keep action_value as slug for mobile app icon mapping
                }
            }
        }

        $homeSection->items()->create($validated);

        return redirect()->back()->with('success', 'Item added to section successfully');
    }

    public function removeItem(HomeSection $homeSection, \App\Models\HomeSectionItem $item)
    {
        // Don't delete the actual image file if it's shared with store/food
        // For simplicity, we just delete the item record
        $item->delete();
        return redirect()->back()->with('success', 'Item removed from section');
    }

    public function updateItem(Request $request, HomeSection $homeSection, \App\Models\HomeSectionItem $item)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'action_type' => 'required|in:route,url,store,food,service',
            'action_value' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && !str_starts_with($item->image, 'stores/') && !str_starts_with($item->image, 'foods/')) {
                Storage::disk('public')->delete($item->image);
            }
            $validated['image'] = $request->file('image')->store('home-sections/items', 'public');
        }

        $item->update($validated);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:home_sections,key,' . $homeSection->id,
            'type' => 'required|in:banner,store_list,food_list,service_list,promo,custom',
            'is_active' => 'boolean',
        ]);

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

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'uuid|exists:home_sections,id',
        ]);

        foreach ($request->ids as $index => $id) {
            HomeSection::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
