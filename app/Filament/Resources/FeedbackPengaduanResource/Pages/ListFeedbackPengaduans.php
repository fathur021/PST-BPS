<?php

namespace App\Filament\Resources\FeedbackPengaduanResource\Pages;

use App\Filament\Resources\FeedbackPengaduanResource;
use App\Filament\Resources\FeedbackPengaduanResource\Widgets\FeedbackPengaduanOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeedbackPengaduans extends ListRecords
{
    protected static string $resource = FeedbackPengaduanResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            FeedbackPengaduanOverview::class,
        ];
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
