<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interview Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h2>Dear {{ $booking->candidate_name }},</h2>

<p>Thank you for scheduling your interview for the <strong>{{ $booking->position_applied }}</strong> position.</p>

<p>We are pleased to confirm that your interview has been successfully booked. A member of our recruitment team will reach out to you shortly with any additional information you may need.</p>

<h3>📅 Interview Details:</h3>
<ul>
    <li><strong>Date & Time:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</li>
    <li><strong>Interview Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Location:</strong> {{ $booking->slot->location }}</li>
</ul>

@if($booking->candidate_notes)
    <p><strong>Candidate Notes:</strong> {{ $booking->candidate_notes }}</p>
@endif

<p>If you have any questions or need to make changes to your booking, feel free to reply to this email and we’ll be happy to assist.</p>

<p>We look forward to speaking with you.</p>

<p>Kind regards,<br>
    <strong>The Recruitment Team</strong><br>
    [Your Company Name]</p>
</body>
</html>
