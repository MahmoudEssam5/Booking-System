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

class SendBookingReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $reminderTimes = [
            now()->addDay()->format('Y-m-d H:i'),
            now()->addHours(2)->format('Y-m-d H:i'),
        ];

        $bookings = Booking::where('status', 'confirmed')
            ->whereIn(\DB::raw("DATE_FORMAT(start_datetime, '%Y-%m-%d %H:%i')"), $reminderTimes)
            ->get();

        foreach ($bookings as $booking) {
            Mail::to($booking->candidate_email)->queue(new BookingReminder($booking));

            $hrPreferences = $booking->hr?->profile?->notification_preferences ?? [];

            if (!empty($hrPreferences['reminder_1_day']) && $this->is1DayReminder($booking)) {
                Mail::to($booking->hr->email)->queue(new BookingReminderToHR($booking));
            }

            if (!empty($hrPreferences['reminder_2_hours']) && $this->is2HoursReminder($booking)) {
                Mail::to($booking->hr->email)->queue(new BookingReminderToHR($booking));
            }
        }
    }

    protected function is1DayReminder(Booking $booking): bool
    {
        return \Carbon\Carbon::parse($booking->start_datetime)->format('Y-m-d H:i') === now()->addDay()->format('Y-m-d H:i');
    }

    protected function is2HoursReminder(Booking $booking): bool
    {
        return \Carbon\Carbon::parse($booking->start_datetime)->format('Y-m-d H:i') === now()->addHours(2)->format('Y-m-d H:i');
    }
}
