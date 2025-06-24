Interview Reminder

The following interview is scheduled to begin in **{{ $reminderText }}**.

📅 **Interview Time:** {{ \Carbon\Carbon::parse($booking->slot->start_datetime)->format('Y-m-d H:i') }}

Please be prepared.

Thanks,
