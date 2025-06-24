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

    public function __construct(Booking $booking)
    {
        $this->booking = $booking->load('slot', 'hr');
    }

    public function build()
    {
        return $this->subject('Reminder: Your interview is coming up')
            ->view('emails.booking_reminder')
            ->withBooking($this->booking);
    }
}
