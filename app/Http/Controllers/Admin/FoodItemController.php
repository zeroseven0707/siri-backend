<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodItem;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodItemController extends Controller
{
    public function index(Request $request)
    {
        $query = FoodItem::with('store');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->filled('available')) {
            $query->where('is_available', $request->available === '1');
        }

        $foods = $query->latest()->paginate(20)->withQueryString();
        $stores = Store::orderBy('name')->get(['id', 'name']);

        return view('admin.food-items.index', compact('foods', 'stores'));
    }

    public function create()
    {
        $stores = Store::orderBy('name')->get(['id', 'name']);
        return view('admin.food-items.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id'     => 'required|uuid|exists:stores,id',
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|max:3072',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        FoodItem::create($validated);

        return redirect()->route('admin.food-items.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(FoodItem $foodItem)
    {
        $stores = Store::orderBy('name')->get(['id', 'name']);
        return view('admin.food-items.edit', compact('foodItem', 'stores'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        $validated = $request->validate([
            'store_id'     => 'required|uuid|exists:stores,id',
            'name'         => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'image'        => 'nullable|image|max:3072',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($foodItem->image) Storage::disk('public')->delete($foodItem->image);
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $foodItem->update($validated);

        return redirect()->route('admin.food-items.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(FoodItem $foodItem)
    {
        if ($foodItem->image) Storage::disk('public')->delete($foodItem->image);
        $foodItem->delete();

        return redirect()->route('admin.food-items.index')->with('success', 'Menu berhasil dihapus.');
    }

    public function toggleAvailable(FoodItem $foodItem)
    {
        $foodItem->update(['is_available' => !$foodItem->is_available]);
        $status = $foodItem->is_available ? 'tersedia' : 'tidak tersedia';
        return redirect()->back()->with('success', "Menu {$foodItem->name} sekarang {$status}.");
    }
}
