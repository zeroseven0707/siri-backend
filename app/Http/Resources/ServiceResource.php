<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'icon'         => $this->icon ? asset('storage/' . $this->icon) : null,
            'base_price'   => $this->base_price,
            'vehicle_type' => $this->vehicle_type,
        ];
    }
}
