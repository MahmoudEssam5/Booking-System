<?php

namespace App\Observers;

use App\Mail\BookingStatusUpdated;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        if ($booking->wasChanged('status') && in_array($booking->status, ['confirmed', 'cancelled'])) {
            Mail::to($booking->candidate_email)->send(new BookingStatusUpdated($booking));

            if ($booking->status === 'confirmed') {
                $booking->confirmed_at = now();
                $booking->cancelled_at = null;
            }

            if ($booking->status === 'cancelled') {
                $booking->cancelled_at = now();
            }

            $booking->saveQuietly();
        }
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
