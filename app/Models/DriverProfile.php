<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverProfile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id', 'vehicle_type', 'license_plate',
        'last_assigned_at', 'current_lat', 'current_lng', 'location_updated_at',
    ];

    protected function casts(): array
    {
        return [
            'last_assigned_at'    => 'datetime',
            'location_updated_at' => 'datetime',
            'current_lat'         => 'decimal:7',
            'current_lng'         => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
