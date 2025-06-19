<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendBookingReminder;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new SendBookingReminder)->everyMinute();
