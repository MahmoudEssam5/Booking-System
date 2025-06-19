<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Interview Booking Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h2>Dear {{ $booking->slot->hr->name }},</h2>

<p>You have received a new interview booking. Below are the details:</p>

<h3>👤 Candidate Information:</h3>
<ul>
    <li><strong>Full Name:</strong> {{ $booking->candidate_name }}</li>
    <li><strong>Email:</strong> {{ $booking->candidate_email }}</li>
    <li><strong>Phone Number:</strong> {{ $booking->candidate_phone }}</li>
    <li><strong>Applied Position:</strong> {{ $booking->position_applied }}</li>
</ul>

<h3>📅 Interview Details:</h3>
<ul>
    <li><strong>Date & Time:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</li>
    <li><strong>Interview Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Location:</strong> {{ $booking->slot->location }}</li>
</ul>

@if($booking->candidate_notes)
    <p><strong>Candidate Notes:</strong><br>{{ $booking->candidate_notes }}</p>
@endif

<p>To manage or review this booking, please log into the system.</p>

<p>Best regards,<br>
    <strong>The Recruitment Platform</strong></p>
</body>
</html>
