<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Filament\Resources\GuestBookResource;
use App\Models\Request;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGuestBook extends ViewRecord
{
    protected static string $resource = GuestBookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
