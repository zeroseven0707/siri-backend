<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'key'      => $this->key,
            'type'     => $this->type,
            'order'    => $this->order,
            'is_active'=> $this->is_active,
            'items'    => HomeSectionItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
