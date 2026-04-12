<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSectionItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'subtitle'     => $this->subtitle,
            'image'        => $this->image,
            'action_type'  => $this->action_type,
            'action_value' => $this->action_value,
            'order'        => $this->order,
            'is_active'    => $this->is_active,
        ];
    }
}
