<?php

namespace App\Livewire;

use App\Models\HrProfile;
use Livewire\Component;

class BookingCalendar extends Component
{
    public \App\Models\HrProfile $hr;
    public $selectedSlotId = null;

    protected $listeners = ['selectSlot'];

    public function mount($slug)
    {
        $this->hr = HrProfile::where('booking_link_slug', $slug)->firstOrFail();
    }

    public function selectSlot($slotId): void
    {
        $this->selectedSlotId = $slotId;
    }

    public function render()
    {
        $slots = $this->hr->user
            ->availabilitySlots()
            ->where('is_active', true)
            ->orderBy('start_datetime')
            ->get();

        return view('livewire.booking-calendar', [
            'slots' => $slots,
            'hr' => $this->hr,
        ]);
    }
}
