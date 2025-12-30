<?php

namespace App\Filament\Resources\FormPengaduanResource\Pages;

use App\Filament\Resources\FormPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormPengaduan extends EditRecord
{
    protected static string $resource = FormPengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
