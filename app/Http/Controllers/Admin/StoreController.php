<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stores = $query->latest()->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.stores.partials.table', compact('stores'))->render(),
                'pagination' => view('admin.partials.pagination', ['data' => $stores])->render(),
            ]);
        }

        return view('admin.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string',
            'phone'       => 'required|string',
            'image'       => 'nullable|image|max:5120',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'is_open'     => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('stores', 'public');
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']) . '-' . \Illuminate\Support\Str::random(5);

        Store::create($validated);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store created successfully');
    }

    public function edit(Store $store)
    {
        $store->load('foodItems');
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'address'     => 'required|string',
            'phone'       => 'required|string',
            'image'       => 'nullable|image|max:5120',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'is_open'     => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($store->image) {
                Storage::disk('public')->delete($store->image);
            }
            $validated['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($validated);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store updated successfully');
    }

    public function destroy(Store $store)
    {
        if ($store->image) {
            Storage::disk('public')->delete($store->image);
        }

        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully');
    }

    public function addFood(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $store->foodItems()->create($validated);

        return redirect()->back()->with('success', 'Food item added successfully');
    }

    public function updateFood(Request $request, Store $store, \App\Models\FoodItem $foodItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($foodItem->image) Storage::disk('public')->delete($foodItem->image);
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $foodItem->update($validated);

        return redirect()->back()->with('success', 'Food item updated successfully');
    }

    public function removeFood(Store $store, \App\Models\FoodItem $foodItem)
    {
        if ($foodItem->image) Storage::disk('public')->delete($foodItem->image);
        $foodItem->delete();

        return redirect()->back()->with('success', 'Food item removed successfully');
    }
}
