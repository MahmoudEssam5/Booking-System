<?php

namespace App\Filament\Resources\HrProfileResource\Pages;

use App\Filament\Resources\HrProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHrProfiles extends ListRecords
{
    protected static string $resource = HrProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
