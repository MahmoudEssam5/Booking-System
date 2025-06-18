<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HrProfile extends Model
{
    protected $fillable = [
        'user_id', 'department', 'position', 'bio', 'profile_image',
        'booking_link_slug', 'notification_preferences', 'timezone'
    ];

    protected $casts = [
        'notification_preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

