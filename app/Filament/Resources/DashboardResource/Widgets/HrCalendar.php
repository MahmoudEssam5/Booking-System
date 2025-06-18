<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use Filament\Widgets\Widget;
use App\Models\AvailabilitySlot;
use Illuminate\Support\Facades\Auth;


class HrCalendar extends Widget
{
    protected static string $view = 'filament.widgets.hr-calendar';

    protected static ?int $sort = 3;

    public function getViewData(): array
    {
        $user = Auth::user();
        $query = AvailabilitySlot::query();

        if ($user->role === 'hr_manager') {
            $query->where('hr_user_id', $user->id);
        }

        $events = $query->get()->filter(function ($slot) {
            return $slot->start_datetime && $slot->end_datetime;
        })->map(function ($slot) {
            return [
                'title' => $slot->interview_type . ' - ' . $slot->start_datetime->format('H:i'),
                'start' => $slot->start_datetime->toIso8601String(),
                'end' => $slot->end_datetime->toIso8601String(),
            ];
        });

        return [
            'events' => $events,
        ];
    }

    protected static bool $isLazy = false;

    protected static ?string $maxWidth = 'full';


}
