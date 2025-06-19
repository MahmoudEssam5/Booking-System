<h2>Hello {{ $booking->candidate_name }},</h2>
<p>Your interview has been <strong>confirmed</strong> for the position of {{ $booking->position_applied }}.</p>
<p><strong>Date & Time:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</p>
<p>We look forward to meeting you!</p>
