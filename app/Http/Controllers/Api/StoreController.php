<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodItemRequest;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\FoodItemResource;
use App\Http\Resources\StoreResource;
use App\Models\FoodItem;
use App\Models\Store;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    use ApiResponse;

    // Public: list all active stores
    public function index(): JsonResponse
    {
        $stores = Store::where('is_active', true)->latest()->paginate(15);

        return $this->success([
            'stores'     => StoreResource::collection($stores),
            'pagination' => [
                'current_page' => $stores->currentPage(),
                'last_page'    => $stores->lastPage(),
                'total'        => $stores->total(),
            ],
        ]);
    }

    // Public: show single store with food items
    public function show(string $id): JsonResponse
    {
        $store = Store::with('foodItems')->where('is_active', true)->find($id);

        if (!$store) {
            return $this->error('Store not found', 404);
        }

        return $this->success(new StoreResource($store));
    }

    // Owner/Admin: create store
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['slug']    = Str::slug($data['name']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store = Store::create($data);

        return $this->success(new StoreResource($store), 'Store created', 201);
    }

    // Owner/Admin: update store
    public function update(StoreRequest $request, string $id): JsonResponse
    {
        $store = Store::find($id);

        if (!$store) {
            return $this->error('Store not found', 404);
        }

        if (!$request->user()->isAdmin() && $store->user_id !== $request->user()->id) {
            return $this->error('Forbidden', 403);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($store->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($store->image);
            }
            $data['image'] = $request->file('image')->store('stores', 'public');
        }

        $store->update($data);

        return $this->success(new StoreResource($store), 'Store updated');
    }

    // Owner/Admin: delete store
    public function destroy(Request $request, string $id): JsonResponse
    {
        $store = Store::find($id);

        if (!$store) {
            return $this->error('Store not found', 404);
        }

        if (!$request->user()->isAdmin() && $store->user_id !== $request->user()->id) {
            return $this->error('Forbidden', 403);
        }

        $store->delete();

        return $this->success(null, 'Store deleted');
    }

    // --- Food Items under a store ---

    public function foodItems(string $storeId): JsonResponse
    {
        $store = Store::find($storeId);

        if (!$store) {
            return $this->error('Store not found', 404);
        }

        $items = $store->foodItems()->where('is_available', true)->get();

        return $this->success(FoodItemResource::collection($items));
    }

    public function addFoodItem(FoodItemRequest $request, string $storeId): JsonResponse
    {
        $store = Store::find($storeId);

        if (!$store) {
            return $this->error('Store not found', 404);
        }

        if (!$request->user()->isAdmin() && $store->user_id !== $request->user()->id) {
            return $this->error('Forbidden', 403);
        }

        $item = $store->foodItems()->create($request->validated());

        return $this->success(new FoodItemResource($item), 'Food item added', 201);
    }

    public function updateFoodItem(FoodItemRequest $request, string $storeId, string $itemId): JsonResponse
    {
        $store = Store::find($storeId);
        $item  = FoodItem::where('store_id', $storeId)->find($itemId);

        if (!$store || !$item) {
            return $this->error('Not found', 404);
        }

        if (!$request->user()->isAdmin() && $store->user_id !== $request->user()->id) {
            return $this->error('Forbidden', 403);
        }

        $item->update($request->validated());

        return $this->success(new FoodItemResource($item), 'Food item updated');
    }

    public function deleteFoodItem(Request $request, string $storeId, string $itemId): JsonResponse
    {
        $store = Store::find($storeId);
        $item  = FoodItem::where('store_id', $storeId)->find($itemId);

        if (!$store || !$item) {
            return $this->error('Not found', 404);
        }

        if (!$request->user()->isAdmin() && $store->user_id !== $request->user()->id) {
            return $this->error('Forbidden', 403);
        }

        $item->delete();

        return $this->success(null, 'Food item deleted');
    }
}
