<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Admin' => Tab::make()->query(fn (Builder $query) => $query->whereHas('roles', fn ($query) => $query->where('name', 'admin'))),
            'Petugas PST' => Tab::make()->query(fn (Builder $query) => $query->whereHas('roles', fn ($query) => $query->where('name', 'pst'))),
            'Front Office' => Tab::make()->query(fn (Builder $query) => $query->whereHas('roles', fn ($query) => $query->where('name', 'front-office'))),
        ];
    }
}
