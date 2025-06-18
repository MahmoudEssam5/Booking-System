<?php

namespace App\Filament\Resources\SlotsResource\Pages;

use App\Filament\Resources\SlotsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlots extends EditRecord
{
    protected static string $resource = SlotsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
