<?php

namespace App\Jobs;

use App\Mail\BookingReminder;
use App\Mail\BookingReminderToHR;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBookingReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $now = now();

        $bookings = Booking::with(['slot', 'hr.HrProfile'])
            ->where('status', 'confirmed')
            ->get();


        foreach ($bookings as $booking) {
            $slotTime = $booking->slot?->start_datetime;

            if (!$slotTime || !$booking->hr) {
                continue;
            }

            $prefs = collect($booking->hr?->notification_preferences);
            $diffInMinutes = (int) round($now->diffInMinutes($slotTime, false));


            Log::info("Testing Reminder Logic for booking #{$booking->id}");
            Log::info("diffInMinutes = $diffInMinutes");
            Log::info("prefs = " . json_encode($prefs->all()));
            Log::info("notified_2_hours_at = " . var_export($booking->notified_2_hours_at, true));


            if (
                is_null($booking->notified_2_hours_at) &&
                abs($diffInMinutes - 120) <= 3 &&
                $prefs->contains('reminder_2_hours')
            ) {
                $booking->notified_2_hours_at = now();
                $booking->save();
                Log::info("Sent 2-hour reminder for booking #{$booking->id}, Diff: {$diffInMinutes}");
                $this->sendReminderEmails($booking);
            }


            if (
                is_null($booking->notified_1_day_at) &&
                abs($diffInMinutes - 1440) <= 3 &&
                $prefs->contains('reminder_1_day')
            ) {
                $booking->notified_1_day_at = now();
                $booking->save();

                Log::info("Sent 1-day reminder for booking #{$booking->id}, Diff: {$diffInMinutes}");
                $this->sendReminderEmails($booking);
            }
        }
    }

    private function sendReminderEmails(Booking $booking): void
    {
        Log::info("Sending emails for booking {$booking->id}");

        if (!empty($booking->candidate_email)) {
            Mail::to($booking->candidate_email)
                ->queue(new BookingReminder($booking));
        }

        if (!empty($booking->hr?->email)) {
            Mail::to($booking->hr->email)
                ->queue(new BookingReminderToHR($booking));
        }
    }
}
