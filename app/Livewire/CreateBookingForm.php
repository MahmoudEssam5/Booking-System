<?php

namespace App\Livewire;

use App\Mail\NotifyHrOfBooking;
use App\Models\Booking;
use App\Models\AvailabilitySlot;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmationMail;


class CreateBookingForm extends Component
{
    public AvailabilitySlot $slot;

    public string $candidate_name = '';
    public string $candidate_email = '';
    public string $candidate_phone = '';
    public string $position_applied = '';
    public string $candidate_notes = '';

    public bool $success = false;

    public function mount($slotId): void
    {
        $this->slot = AvailabilitySlot::findOrFail($slotId);
    }

    public function rules(): array
    {
        return [
            'candidate_name' => 'required|string|max:255',
            'candidate_email' => 'required|email',
            'candidate_phone' => 'required|string|max:20',
            'position_applied' => 'required|string|max:255',
            'candidate_notes' => 'nullable|string',
        ];
    }


    public function submit(): void
    {
        $this->validate();

        $duplicate = Booking::where('slot_id', $this->slot->id)
            ->where('position_applied', $this->position_applied)
            ->where(function ($query) {
                $query->where('candidate_email', $this->candidate_email)
                    ->orWhere('candidate_phone', $this->candidate_phone);
            })
            ->exists();

        if ($duplicate) {
            $this->addError('duplicate', 'You have already applied for this position with the same email or phone number.');
            return;
        }

        Booking::create([
            'slot_id' => $this->slot->id,
            'hr_user_id' => $this->slot->hr_user_id,
            'candidate_name' => $this->candidate_name,
            'candidate_email' => $this->candidate_email,
            'candidate_phone' => $this->candidate_phone,
            'position_applied' => $this->position_applied,
            'interview_type' => $this->slot->interview_type,
            'status' => 'pending',
            'candidate_notes' => $this->candidate_notes,
            'booking_token' => Str::uuid(),
        ]);

        $this->reset([
            'candidate_name',
            'candidate_email',
            'candidate_phone',
            'position_applied',
            'candidate_notes'
        ]);

        $this->success = true;

        $booking = Booking::latest()->first();

        Mail::to($booking->candidate_email)->send(new BookingConfirmationMail($booking));
        Mail::to($this->slot->hr->email)->send(new NotifyHrOfBooking($booking));
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.create-booking-form');
    }
}
