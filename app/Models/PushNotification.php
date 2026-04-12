<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PushNotification extends Model
{
    use HasUuids;

    protected $fillable = [
        'title', 'body', 'image', 'data',
        'target', 'sent_by', 'recipient_count', 'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'data'    => 'array',
            'sent_at' => 'datetime',
        ];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'push_notification_reads', 'push_notification_id', 'user_id')
            ->withPivot('read_at');
    }
}
