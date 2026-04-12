<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'amount'     => $this->amount,
            'type'       => $this->type,
            'status'     => $this->status,
            'reference'  => $this->reference,
            'order_id'   => $this->order_id,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
