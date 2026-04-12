<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FoodItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'store_id'     => $this->store_id,
            'store'        => new StoreResource($this->whenLoaded('store')),
            'name'         => $this->name,
            'price'        => $this->price,
            'description'  => $this->description,
            'image'        => $this->image,
            'is_available' => $this->is_available,
        ];
    }
}
