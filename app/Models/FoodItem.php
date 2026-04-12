<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['store_id', 'name', 'price', 'description', 'image', 'is_available'];

    protected function casts(): array
    {
        return [
            'price'        => 'decimal:2',
            'is_available' => 'boolean',
        ];
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
