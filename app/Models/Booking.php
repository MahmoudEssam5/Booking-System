<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'slot_id',
        'hr_user_id',
        'candidate_name',
        'candidate_email',
        'candidate_phone',
        'position_applied',
        'interview_type',
        'status',
        'candidate_notes',
        'hr_notes',
        'booking_token',
        'confirmed_at',
        'cancelled_at'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function slot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AvailabilitySlot::class);
    }

    public function hr(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'hr_user_id');
    }
}

