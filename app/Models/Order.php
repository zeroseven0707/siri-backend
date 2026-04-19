<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'driver_id', 'assigned_driver_id', 'service_id',
        'status', 'pickup_location', 'destination_location',
        'price', 'notes', 'completion_token',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function assignedDriver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_driver_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function foodItems(): HasMany
    {
        return $this->hasMany(FoodOrderItem::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(FoodOrderItem::class);
    }

    // Get store from first food item (if exists)
    public function getStoreAttribute()
    {
        $firstItem = $this->foodItems()->with('foodItem.store')->first();
        return $firstItem?->foodItem?->store;
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
