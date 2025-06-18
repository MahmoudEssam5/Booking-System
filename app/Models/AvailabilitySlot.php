<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    protected $fillable = [
        'hr_user_id',
        'title',
        'start_datetime',
        'end_datetime',
        'duration_minutes',
        'capacity',
        'location',
        'interview_type',
        'description',
        'is_recurring',
        'recurring_pattern',
        'is_active'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_recurring' => 'boolean',
        'recurring_pattern' => 'array',
        'is_active' => 'boolean',
    ];

    public function hr(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'hr_user_id')
            ->where('role', 'hr_manager');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'slot_id');
    }
}
