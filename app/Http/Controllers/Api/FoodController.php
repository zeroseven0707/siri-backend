<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodItemResource;
use App\Models\FoodItem;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    use ApiResponse;

    public function show(string $id): JsonResponse
    {
        $food = FoodItem::with(['store.foodItems' => fn ($q) => $q->where('is_available', true)])
            ->find($id);

        if (!$food) {
            return $this->error('Food item not found', 404);
        }

        return $this->success([
            'food_item' => new FoodItemResource($food),
            'store'     => new \App\Http\Resources\StoreResource($food->store),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = FoodItem::with('store')->where('is_available', true);

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $foods = $query->latest()->paginate(20);

        return $this->success([
            'foods'      => FoodItemResource::collection($foods),
            'pagination' => [
                'current_page' => $foods->currentPage(),
                'last_page'    => $foods->lastPage(),
                'total'        => $foods->total(),
            ],
        ]);
    }
}
