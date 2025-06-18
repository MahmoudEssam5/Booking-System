<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interview Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
<h2>Hello {{ $booking->candidate_name }},</h2>

<p>Thank you for booking an interview for the <strong>{{ $booking->position_applied }}</strong> position.</p>

<p>Your booking has been received successfully. Our team will contact you shortly with further details.</p>

<h3>Interview Details:</h3>
<ul>
    <li><strong>Date & Time:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</li>
    <li><strong>Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Location:</strong> {{ $booking->slot->location }}</li>
</ul>

@if($booking->candidate_notes)
    <p><strong>Your Notes:</strong> {{ $booking->candidate_notes }}</p>
@endif

<p>If you have any questions, feel free to reply to this email.</p>

<p>Best regards,<br>
    The Recruitment Team</p>
</body>
</html>
