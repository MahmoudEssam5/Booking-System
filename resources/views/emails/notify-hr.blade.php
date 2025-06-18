<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Booking Notification</title>
</head>
<body style="font-family: Arial, sans-serif;">
<h2>Hi {{ $booking->slot->hr->name }},</h2>

<p>A new interview booking has been submitted.</p>

<h3>Candidate Details:</h3>
<ul>
    <li><strong>Name:</strong> {{ $booking->candidate_name }}</li>
    <li><strong>Email:</strong> {{ $booking->candidate_email }}</li>
    <li><strong>Phone:</strong> {{ $booking->candidate_phone }}</li>
    <li><strong>Position:</strong> {{ $booking->position_applied }}</li>
</ul>

<h3>Interview Details:</h3>
<ul>
    <li><strong>Date & Time:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</li>
    <li><strong>Type:</strong> {{ $booking->interview_type }}</li>
    <li><strong>Location:</strong> {{ $booking->slot->location }}</li>
</ul>

@if($booking->candidate_notes)
    <p><strong>Notes:</strong> {{ $booking->candidate_notes }}</p>
@endif

<p>Please log into the system to manage the booking.</p>

<p>Thanks,<br>The Booking System</p>
</body>
</html>
