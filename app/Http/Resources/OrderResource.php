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
            'pickup_lat'           => $this->pickup_lat,
            'pickup_lng'           => $this->pickup_lng,
            'destination_location' => $this->destination_location,
            'destination_lat'      => $this->destination_lat,
            'destination_lng'      => $this->destination_lng,
            'price'                => $this->price,
            'delivery_fee'         => $this->delivery_fee,
            'notes'                => $this->notes,
            'service'              => new ServiceResource($this->whenLoaded('service')),
            'user'                 => new UserResource($this->whenLoaded('user')),
            'driver'               => new UserResource($this->whenLoaded('driver')),
            'assigned_driver'      => new UserResource($this->whenLoaded('assignedDriver')),
            'food_items'           => FoodOrderItemResource::collection($this->whenLoaded('foodItems')),
            'store'                => $this->whenLoaded('foodItems', function () {
                // Ambil store dari food item pertama (semua item dari store yang sama)
                $store = $this->foodItems->first()?->foodItem?->store;
                if (!$store) return null;
                return [
                    'id'        => $store->id,
                    'name'      => $store->name,
                    'address'   => $store->address,
                    'latitude'  => $store->latitude,
                    'longitude' => $store->longitude,
                ];
            }),
            'created_at'           => $this->created_at->toISOString(),
            'cancel_deadline'      => $this->created_at->addSeconds(10)->toISOString(),
            'can_cancel'           => $this->status === 'pending'
                                        && $this->created_at->diffInSeconds(now()) <= 10,
            'can_confirm'          => $this->status === 'on_progress',
            // QR token — hanya dikirim ke driver yang menangani order ini
            'completion_token'     => $this->when(
                $request->user()?->isDriver() && $this->driver_id === $request->user()?->id,
                $this->completion_token
            ),
        ];
    }
}
