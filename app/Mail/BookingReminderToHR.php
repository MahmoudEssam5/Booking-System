<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminderToHR extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $reminderText;

    public function __construct(Booking $booking, string $reminderText)
    {
        $this->booking = $booking->load('slot', 'hr');
        $this->reminderText = $reminderText;
    }

    public function build()
    {
        return $this->subject("Reminder: Upcoming Interview with Candidate")
            ->view('emails.hr_booking_reminder')
            ->with([
                'booking' => $this->booking,
                'reminderText' => $this->reminderText,
            ]);
    }
}
