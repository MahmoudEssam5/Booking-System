<?php

namespace App\Jobs;

use App\Mail\BookingReminder;
use App\Mail\BookingReminderToHR;
use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBookingReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $now = now();

        $oneDayStart = $now->copy()->addDay()->startOfMinute();
        $oneDayEnd = $oneDayStart->copy()->endOfMinute();

        $twoHoursStart = $now->copy()->addHours(2)->startOfMinute();
        $twoHoursEnd = $twoHoursStart->copy()->endOfMinute();

        $bookings = Booking::with(['hr.profile'])
            ->where('status', 'confirmed')
            ->where(function ($query) use ($oneDayStart, $oneDayEnd, $twoHoursStart, $twoHoursEnd) {
                $query->whereBetween('start_datetime', [$oneDayStart, $oneDayEnd])
                    ->orWhereBetween('start_datetime', [$twoHoursStart, $twoHoursEnd]);
            })
            ->get();

        foreach ($bookings as $booking) {
            Mail::to($booking->candidate_email)->queue(new BookingReminder($booking));
            Log::info("Booking reminder sent to candidate: {$booking->candidate_email}");

            $hr = $booking->hr;
            $preferences = $hr?->profile?->notification_preferences ?? [];

            if (!empty($preferences['reminder_1_day']) && $this->isWithinMinuteRange($booking->start_datetime, $oneDayStart)) {
                Mail::to($hr->email)->queue(new BookingReminderToHR($booking));
                Log::info("1-day reminder sent to HR: {$hr->email}");
            }

            if (!empty($preferences['reminder_2_hours']) && $this->isWithinMinuteRange($booking->start_datetime, $twoHoursStart)) {
                Mail::to($hr->email)->queue(new BookingReminderToHR($booking));
                Log::info("2-hours reminder sent to HR: {$hr->email}");
            }
        }
    }

    protected function isWithinMinuteRange($datetime, $target): bool
    {
        return $datetime->between($target, $target->copy()->endOfMinute());
    }
}
