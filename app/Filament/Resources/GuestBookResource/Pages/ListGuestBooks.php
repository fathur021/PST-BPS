<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Filament\Resources\GuestBookResource;
use App\Filament\Resources\GuestBookResource\Widgets\GuestBookOverview;
use App\Filament\Resources\GuestBookResource\Widgets\PendingGuestBooksWidget;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListGuestBooks extends ListRecords
{
    protected static string $resource = GuestBookResource::class;

    protected function getHeaderWidgets(): array
    {
        $widgets = [
            GuestBookOverview::class,
        ];

        if (auth()->user()->hasRole('pst')) {
            $widgets[] = PendingGuestBooksWidget::class;
        }

        return $widgets;
    }
    
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array {
        return [
            null => Tab::make('All'),
            'In Progress' => Tab::make()->query(fn ($query) => $query->where('status', 'inProgress' )),
            'Done' => Tab::make()->query(fn ($query) => $query->where('status', 'done' )),
        ];
    }

    protected function getListeners(): array
    {
        return [
            'guestBookAccepted' => '$refresh',
            'refreshWidget' => '$refresh',
        ];
    }

}
