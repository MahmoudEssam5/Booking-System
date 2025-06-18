<?php

use App\Models\HrProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\BookingCalendar;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/book/{slug}', BookingCalendar::class);
