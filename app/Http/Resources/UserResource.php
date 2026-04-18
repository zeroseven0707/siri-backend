<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'role'           => $this->role,
            'address'        => $this->address,
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude,
            'is_active'      => (bool) $this->is_active,
            'profile_picture'=> $this->profile_picture
                                    ? asset('storage/' . $this->profile_picture)
                                    : null,
            'driver_profile' => new DriverProfileResource($this->whenLoaded('driverProfile')),
            'created_at'     => $this->created_at->toISOString(),
        ];
    }
}
