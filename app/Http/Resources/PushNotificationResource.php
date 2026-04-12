<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PushNotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'body'       => $this->body,
            'image'      => $this->image,
            'data'       => $this->data,
            'type'       => $this->type,
            'target'     => $this->target,
            'is_read'    => $this->whenPivotLoaded('push_notification_reads',
                fn () => true, false),
            'sent_at'    => $this->sent_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
