<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminder extends Mailable
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
        return $this->subject("Reminder: Your interview is coming up")
            ->view('emails.booking_reminder')
            ->with([
                'booking' => $this->booking,
                'reminderText' => $this->reminderText,
            ]);
    }
}

