<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        $query = Booking::query();

        if ($user->role === 'hr_manager') {
            $query->where('hr_user_id', $user->id);
        }

        return [
            Card::make('Total Bookings', Booking::count()),
            Card::make('Today\'s Bookings', Booking::whereDate('created_at', today())->count()),
            Card::make('Confirmed Bookings', Booking::where('status', 'confirmed')->count()),
        ];
    }
}
