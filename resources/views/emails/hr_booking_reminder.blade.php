<p>Hello {{ $booking->hr->name ?? 'HR Manager' }},</p>

<p>This is a reminder for your upcoming interview with a candidate:</p>

<ul>
    <li><strong>Candidate:</strong> {{ $booking->candidate_name }}</li>
    <li><strong>Email:</strong> {{ $booking->candidate_email }}</li>
    <li><strong>Phone:</strong> {{ $booking->candidate_phone }}</li>
    <li><strong>Position:</strong> {{ $booking->position_applied }}</li>
    <li><strong>Interview Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($booking->start_datetime)->format('Y-m-d H:i') }}</li>
    <li><strong>Location:</strong> {{ $booking->location }}</li>
</ul>

<p>Please be prepared.</p>
