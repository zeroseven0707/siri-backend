<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodOrderItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['order_id', 'food_item_id', 'qty', 'price'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function foodItem(): BelongsTo
    {
        return $this->belongsTo(FoodItem::class);
    }
}
