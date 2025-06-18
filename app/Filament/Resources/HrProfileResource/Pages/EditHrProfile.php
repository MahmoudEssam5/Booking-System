<?php

namespace App\Filament\Resources\HrProfileResource\Pages;

use App\Filament\Resources\HrProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHrProfile extends EditRecord
{
    protected static string $resource = HrProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
