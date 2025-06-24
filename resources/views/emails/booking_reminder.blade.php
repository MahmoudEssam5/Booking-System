Hello {{ $booking->candidate_name }},

This is a reminder that your interview will start in **{{ $reminderText }}**.

<li><strong>Position:</strong> {{ $booking->position_applied }}</li>
<li><strong>Interview Type:</strong> {{ $booking->interview_type }}</li>
📅 **Interview Time:** {{ \Carbon\Carbon::parse($booking->slot->start_datetime)->format('Y-m-d H:i') }}

Good luck!

Thanks,
