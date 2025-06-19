<?php

use App\Models\HrProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\BookingCalendar;


Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('admin/login');


Route::get('/book/{slug}', BookingCalendar::class);
