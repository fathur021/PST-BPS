<?php

namespace App\Filament\Resources\FeedbackPengaduanResource\Pages;

use App\Filament\Resources\FeedbackPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeedbackPengaduan extends EditRecord
{
    protected static string $resource = FeedbackPengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
