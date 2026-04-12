<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'status'               => $this->status,
            'pickup_location'      => $this->pickup_location,
            'destination_location' => $this->destination_location,
            'price'                => $this->price,
            'notes'                => $this->notes,
            'service'              => new ServiceResource($this->whenLoaded('service')),
            'user'                 => new UserResource($this->whenLoaded('user')),
            'driver'               => new UserResource($this->whenLoaded('driver')),
            'food_items'           => FoodOrderItemResource::collection($this->whenLoaded('foodItems')),
            'created_at'           => $this->created_at->toISOString(),
        ];
    }
}
