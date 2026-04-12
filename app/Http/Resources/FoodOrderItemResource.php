<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodOrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'food_item' => new FoodItemResource($this->whenLoaded('foodItem')),
            'qty'       => $this->qty,
            'price'     => $this->price,
        ];
    }
}
