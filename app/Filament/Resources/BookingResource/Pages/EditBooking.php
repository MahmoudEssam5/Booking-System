<?php

namespace App\Filament\Resources\BookingResource\Pages;

use AllowDynamicProperties;
use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Mail\BookingStatusUpdated;
use Illuminate\Support\Facades\Mail;

#[AllowDynamicProperties] class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $booking = $this->record;

        if (in_array($booking->status, ['confirmed', 'cancelled'])) {
            Mail::to($booking->candidate_email)->send(new BookingStatusUpdated($booking));

        }


    }
}
