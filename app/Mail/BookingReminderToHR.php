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

    public function __construct(Booking $booking)
    {
        $this->booking = $booking->load('slot', 'hr');
    }

    public function build()
    {
        return $this->subject('Reminder: Upcoming Interview with Candidate')
            ->view('emails.hr_booking_reminder')
            ->withBooking($this->booking);
    }
}
