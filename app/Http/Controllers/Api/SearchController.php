<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodItemResource;
use App\Http\Resources\StoreResource;
use App\Models\FoodItem;
use App\Models\Store;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return $this->error('Query minimal 2 karakter', 422);
        }

        $stores = Store::where('is_active', true)
            ->where(fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->orWhere('address', 'like', "%{$q}%")
            )
            ->limit(10)
            ->get();

        $foods = FoodItem::with('store')
            ->where('is_available', true)
            ->where(fn ($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
            )
            ->limit(15)
            ->get();

        return $this->success([
            'query'  => $q,
            'stores' => StoreResource::collection($stores),
            'foods'  => FoodItemResource::collection($foods),
            'total'  => $stores->count() + $foods->count(),
        ]);
    }
}
