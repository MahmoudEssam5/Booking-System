<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif;">
<h2>Hello {{ $booking->candidate_name }},</h2>

@if($booking->status === 'accepted')
    <p>Congratulations! Your interview booking has been <strong>accepted</strong>.</p>
    <p>Please be available on:</p>
@else
    <p>Unfortunately, your interview booking has been <strong>rejected</strong>.</p>
    <p>You may try applying again later or for a different position.</p>
@endif

<ul>
    <li><strong>Position:</strong> {{ $booking->position_applied }}</li>
    <li><strong>Interview Date:</strong> {{ $booking->slot->start_datetime->format('l, F j, Y \a\t h:i A') }}</li>
    <li><strong>Location:</strong> {{ $booking->slot->location }}</li>
</ul>

<p>Thank you,<br>The HR Team</p>
</body>
</html>
