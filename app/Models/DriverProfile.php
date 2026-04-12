<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverProfile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['user_id', 'vehicle_type', 'license_plate', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
