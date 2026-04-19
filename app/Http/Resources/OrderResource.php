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
            'assigned_driver'      => new UserResource($this->whenLoaded('assignedDriver')),
            'food_items'           => FoodOrderItemResource::collection($this->whenLoaded('foodItems')),
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
