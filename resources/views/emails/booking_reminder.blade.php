<p>Hello {{ $booking->candidate_name }},</p>

<p>This is a reminder for your upcoming interview:</p>

<ul>
    <li><strong>Position:</strong> {{ $booking->position_applied }}</li>
    <li><strong>Interview Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($booking->start_datetime)->format('Y-m-d H:i') }}</li>
    <li><strong>Location:</strong> {{ $booking->location }}</li>
</ul>

<p>We wish you the best of luck!</p>
