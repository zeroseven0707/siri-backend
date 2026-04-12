<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description',
        'image', 'address', 'latitude', 'longitude',
        'is_open', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_open'   => 'boolean',
            'is_active' => 'boolean',
            'latitude'  => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function foodItems(): HasMany
    {
        return $this->hasMany(FoodItem::class);
    }
}
